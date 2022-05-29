<?php

namespace App\Models;

use App\Jobs\IndexProducts;
use App\Libraries\ElasticsearchHelper;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Log;

config(['laravel-model-caching.disabled' => true]);
ini_set('memory_limit', '512M');

if (! isset($new_product_table)) {
	$new_product_table = (new Product)->getTable();
}

class ProductTemp extends \App\Models\Product
{
	public function __construct()
	{
		global $new_product_table;
		$this->table = str_replace(DB::connection()->getTablePrefix(), '', $new_product_table);

		return parent::__construct();
	}
}

class ImportTask extends Model
{
	const CHUNK_SIZE = 10000;

	const CHUNK_SIZE_2 = 750;

	const LEVENSHTEIN_DISTANCE = 3;

	public $guarded = [];

	protected $attributes = [
		'finished' => false,
	];

	public static function boot()
	{
		parent::boot();

		self::created(function ($that) {
			if ($that->finished) {
				return;
			}

			\App\Jobs\ImportProducts::withChain([
				new \App\Jobs\UpdateBrands($that),
			])->dispatch($that);
		});
	}

	private function getProductTableName()
	{
		return DB::connection()->getTablePrefix().(new Product)->getTable();
	}

	public function run_import()
	{
		global $new_product_table;

		$this->save();

		try {
			$new_product_table = $this->import_products();
			$new_index = $this->index_products();
		} catch (Exception $e) {
			Log::error('Could not run_import() - '.$e->getMessage());
			app('sentry')->captureException($e);
			throw $e;
		}

		try {
			$this->go_live($new_product_table, $new_index);
		} catch (Exception $e) {
			Log::error("Could not go_live($new_product_table, $new_index) - ".$e->getMessage());
			app('sentry')->captureException($e);
			throw $e;
		}

		$this->save();
		$this->run_scrapy_spider();
	}

	public function run_update_brands()
	{
		$this->save();

		try {
			$this->update_brands();
		} catch (Exception $e) {
			Log::error('Could not update_brands() - '.$e->getMessage());
			app('sentry')->captureException($e);
		}

		$this->finished = true;
		$this->save();
	}

	public function import_products()
	{
		$view_name = $this->getProductTableName();

		$new_table = $view_name.'_'.time();
		$new_table__no_suffix = str_replace(DB::connection()->getTablePrefix(), '', $new_table);

		Log::info("[+] Importing products into '$new_table'");

		DB::statement("CREATE UNLOGGED TABLE $new_table AS SELECT * FROM $view_name limit 1 WITH NO DATA");
		DB::statement("ALTER TABLE $new_table DISABLE TRIGGER ALL");

		foreach (Source::where('enabled', true)->orderBy('priority', 'asc')->get() as $source) {
			$source->import($new_table);
		}

		Schema::table(
			$new_table__no_suffix,
			function ($table) {
				$table->index('i');
				$table->index('slug');

				$table->index('brand_original');
				$table->index('merchant_original');
				$table->index('price');
				$table->index('old_price');
				// $table->index('image_url');
			}
		);

		Log::info("[+] DONE: Importing products into '$new_table'. Now removing duplicates...");

		$time_0 = hrtime(true);

		$deleted_0 = DB::delete("DELETE FROM $new_table a USING $new_table b
			WHERE a.i > b.i
			AND a.slug = b.slug
			");

		$time_1 = hrtime(true);
		$diff_1 = ($time_1 - $time_0) / 1000000000;

		$deleted_1 = DB::delete("DELETE FROM $new_table a USING $new_table b
			WHERE a.i > b.i
			AND a.brand_original = b.brand_original
			AND a.merchant_original = b.merchant_original
			AND a.price = b.price
			AND a.old_price = b.old_price

			AND a.image_url = b.image_url
			");

		$time_2 = hrtime(true);
		$diff_2 = ($time_2 - $time_1) / 1000000000;

		$deleted_2 = DB::delete("DELETE FROM $new_table a USING $new_table b
			WHERE a.i > b.i
			AND a.brand_original = b.brand_original
			AND a.merchant_original = b.merchant_original
			AND (
				a.image_url = b.image_url
				OR
				levenshtein_less_equal(right(a.image_url, 255), right(b.image_url, 255), :levenshtein_distance+1) <= :levenshtein_distance
				)
			AND (
				a.description = b.description
				OR
				(
					((a.description = '') IS NOT FALSE)
					AND
					((b.description = '') IS NOT FALSE)
					)
				)
			AND a.price = b.price
			AND a.old_price = b.old_price
			", [
				'levenshtein_distance' => self::LEVENSHTEIN_DISTANCE,
			]);

		$time_3 = hrtime(true);
		$diff_3 = ($time_3 - $time_2) / 1000000000;

		Log::info("[+] DONE: Removing ($deleted_0 [$diff_1] | $deleted_1 [$diff_2] | $deleted_2 [$diff_3]) duplicates.");

		DB::statement("ALTER TABLE $new_table ENABLE TRIGGER ALL");

		Schema::table(
			$new_table__no_suffix,
			function ($table) {
				$table->dropIndex(['brand_original']);
				$table->dropIndex(['merchant_original']);
				$table->dropIndex(['price']);
				$table->dropIndex(['old_price']);
				// $table->dropIndex(['image_url']);
			}
		);

		Log::info('[+] Adding WAL on PG table...');
		DB::statement("ALTER TABLE $new_table SET LOGGED");

		return $new_table;
	}

	private function populate($index)
	{
		$settings = ElasticsearchHelper::getClient()->indices()->getSettings();
		$settings = $settings[$index]['settings']['index'];

		ElasticsearchHelper::getClient()->indices()->putSettings([
			'index' => $index,
			'body' => [
				'index.refresh_interval' => -1,
				'index.number_of_replicas' => 0,
			],
		]);

		$model = ProductTemp::class;
		$total = ceil($model::count() / self::CHUNK_SIZE);
		$nb_of_groups = ceil(self::CHUNK_SIZE / self::CHUNK_SIZE_2);

		$products = $model::orderBy('i', 'asc')->chunk(
		  self::CHUNK_SIZE,
		  function ($items) use ($index, $total, $nb_of_groups) {
			  static $i = 0;
			  $i++;
			  $j = 0;

			  Log::debug("($i/$total) Indexing products by batch into the ES index.");

			  $params = [];
			  foreach ($items->split($nb_of_groups) as $group) {
				  $j++;
				  $params = [];

				  foreach ($group as $item) {
					  $params['body'][] = [
						  'index' => [
							  '_index' => $index,
						  ],
					  ];

					  $params['body'][] = $item->buildDocument();
				  }

				  try {
					  $ret = ElasticsearchHelper::getClient()->bulk($params);
				  } catch (Exception $e) {
					  Log::error('ERROR on ES->bulk() - '.$e->getMessage());
				  }

				  if (! empty($ret['errors'])) {
					  Log::error('ERROR: importing: '.print_r($ret, true));
				  }
			  }
		  }
	  );

		ElasticsearchHelper::getClient()->indices()->putSettings([
			'index' => $index,
			'body' => [
				'index.refresh_interval' => '30s',
				'index.number_of_replicas' => @$settings['number_of_replicas'] ?: null,
			],
		]);
	}

	private function create_index($index)
	{
		try {
			$params = ['index' => $index];

			if (! ElasticsearchHelper::getClient()->indices()->exists($params)) {
				ElasticsearchHelper::getClient()->indices()->create($params);
				ElasticsearchHelper::getClient()->indices()->putMapping(array_merge($params, [
					'body' => [
						'properties' => [
							'categories' => ['type' => 'text'],
							'price' => ['type' => 'float'],
							'old_price' => ['type' => 'float'],
						],
					],
				]));
			}
		} catch (Exception $e) {
			Log::error("Could not create index ($index) ".$e->getMessage());
		}
	}

	public function index_products()
	{
		global $new_product_table;
		$index_name = 'products-'.time();

		Log::info("[+] Indexing products from table '$new_product_table' into index '$index_name'");

		$this->create_index($index_name);
		$this->populate($index_name);

		Log::info("[+] DONE: Indexing products from table '$new_product_table' into index '$index_name'");

		return $index_name;
	}

	public function go_live($new_table, $new_index)
	{
		Log::info("[+] Going live with new_table: '$new_table', new_index: '$new_index'");

		$view_name = $this->getProductTableName();
		DB::statement("CREATE OR REPLACE VIEW $view_name AS SELECT * FROM $new_table");

		$tables = array_filter(
			DB::connection()->getDoctrineSchemaManager()->listTableNames(),
			function ($v) use ($view_name) {
				return false !== strpos($v, $view_name);
			});

		foreach ($tables as $table) {
			if ($new_table == $table) {
				continue;
			}

			Log::debug("[+] Dropping old table '$table'");
			DB::statement("DROP TABLE $table");
		}

		$alias_name = 'products';
		Log::info('[+] Updating ES aliases');

		try {
			$params = ['index' => '*', 'name' => $alias_name];
			if (ElasticsearchHelper::getClient()->indices()->existsAlias($params)) {
				ElasticsearchHelper::getClient()->indices()->deleteAlias($params);
			}
		} catch (Exception $e) {
			Log::error('Could not update aliases #1 - '.$e->getMessage());

			try {
				ElasticsearchHelper::getClient()->indices()->updateAliases([
					'body' => [
						'actions' => [
							'remove' => [
								'alias' => $alias_name,
								'indices' => '*',
							],
						],
					],
				]);
			} catch (Exception $e) {
				Log::error('Could not update aliases #2 - '.$e->getMessage());
			}
		}

		try {
			ElasticsearchHelper::getClient()->indices()->updateAliases([
				'body' => [
					'actions' => [
						'add' => [
							'alias' => $alias_name,
							'index' => $new_index,
						],
					],
				],
			]);
		} catch (Exception $e) {
			Log::error('Could not update aliases #3 - '.$e->getMessage());
		}
	}

	public function update_brands()
	{
		Log::info('[+] Updating brands');

		$brand_names = DB::select('select distinct brand_original from '.$this->getProductTableName()." where brand_original <> ''");

		$nb = 0;
		foreach ($brand_names as $tuple) {
			Brand::firstOrCreate([
				'slug' => \Slugify::slugify($tuple->brand_original),
			], [
				'name' => $tuple->brand_original,
			]);
			$nb++;
		}

		Log::info("[+] Done. $nb brands updated");
	}

	public function run_scrapy_spider()
	{
		if (! $token = config('imports.SCRAPINGHUB_API_KEY')) {
			return false;
		}

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://app.scrapinghub.com/api/schedule.json?apikey='.env('SCRAPINGHUB_API_KEY'));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'project='.env('SCRAPINGHUB_PROJECT_ID').'&spider='.env('SCRAPINGHUB_SPIDER_NAME'));

		$server_output = curl_exec($ch);

		// Log::debug($server_output);

		curl_close($ch);
	}
}

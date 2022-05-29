<?php

namespace App\Console\Commands;

use App\Libraries\ElasticsearchHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorWhiteList;
use App\Models\Gender;
use App\Models\ProductFromElasticsearch;
use App\Models\WhiteList;
use Illuminate\Console\Command;

class UpdateWhiteList extends Command
{
	protected $signature = 'update:white_lists {brands?*}';

	protected $description = 'Update WhiteList for specified Brands';

	private function do_category($category, $brand, &$genders_detected, &$white_lists_created, $minimum_required_products = WhiteList::MINIMUM_REQUIRED_PRODUCTS)
	{
		$query_params = ElasticsearchHelper::buildQuery([
			'category' => $category,
			'brand' => $brand,
		], 1, [
			'gender' => '',
			'colors' => '',
		]);
		$query_params['size'] = 0;

		try {
			$products = ProductFromElasticsearch::all($query_params);
		} catch (\Exception $e) {
			return false;
		}

		$response_total = $products['response']['total']['value'];
		$response_facets = $products['response']['facets'];

		$category_id = $category ? $category->id : null;

		if ($response_total < $minimum_required_products) {
			return false;
		}

		$genders_to_test = Gender::GENDERS;
		if ($category && Gender::GENDER_BOTH != $category->gender) {
			$genders_to_test = [Gender::GENDER_BOTH, $category->gender];
		}

		foreach ($genders_to_test as $gender) {
			if (Gender::GENDER_BOTH == $gender) {
				$total = $response_total;
			} else {
				if (empty($response_facets['gender'])) {
					continue;
				}

				if (empty($response_facets['gender'][$gender])) {
					continue;
				}

				$total = $response_facets['gender'][$gender]['doc_count'];
			}

			if ($total < $minimum_required_products) {
				continue;
			}

			echo str_pad("\tFound products (brand: $brand, categ: $category, gender: $gender, amount: $total): ", 100);

			$white_list = WhiteList::updateOrCreate([
				'gender' => $gender,
				'brand_id' => $brand->id,
				'category_id' => $category_id,
			], [
				'amount' => $total,
			]);

			$genders_detected[$gender] = true;

			$colors = [];

			if (isset($response_facets['colors'])) {
				foreach ($response_facets['colors'] as $color_raw => $data) {
					$amount = $data['doc_count'];

					if ($amount < $minimum_required_products) {
						continue;
					}

					if ($color = Color::where('name', $color_raw)->first()) {
						$colors[$color->id] = ['amount' => $amount];
					}
				}
			}

			echo '+ attaching '.count($colors).' colors: ';

			$white_list->colors()->sync($colors);

			echo " DONE\n";

			$white_lists_created[] = $white_list;
		}

		if (isset($white_list)) {
			echo "\n";

			return true;
		}
	}

	public function handle()
	{
		$brands = [];
		$opts_brands = $this->argument('brands');

		if (empty($opts_brands)) {
			$query = Brand::all_listing();

			$total_amount_of_brands = $query->count();

			if ($total_amount_of_brands > 100) {
				$brands_per_day = $total_amount_of_brands / 7;

				$query = $query->skip(date('w') * $brands_per_day)->take($brands_per_day);
			}
		} else {
			if ('in_listing' == $opts_brands[0]) {
				$query = Brand::all_listing();
			} else {
				$query = Brand::whereIn('slug', $opts_brands);
			}
		}

		$i = 0;
		$brands = $query->get();
		$numbers_of_brands = $brands->count();

		$categories = Category::withoutRoot()->get();

		echo "[=] Found {$categories->count()} categories and {$numbers_of_brands} brands\n";

		foreach ($brands as $brand) {
			$i++;

			$genders_detected = [];
			$white_lists_created = [];

			echo "[+] Working on ({$brand->slug}) [brand: $i/{$numbers_of_brands}]\n";

			if ($this->do_category(null, $brand, $genders_detected, $white_lists_created)) {
				foreach ($categories as $category) {
					$this->do_category($category, $brand, $genders_detected, $white_lists_created);
				}
			}

			$old_white_lists = WhiteList::where('brand_id', $brand->id)
				->whereNotIn('id', collect($white_lists_created)->pluck('id'));

			if ($nb_old = $old_white_lists->count()) {
				$nb = 0;
				foreach ($old_white_lists->get() as $white_list) {
					if (! $this->do_category($white_list->category, $white_list->brand, $genders_detected, $white_lists_created, 1)) {
						$white_list->delete();
						$nb++;
					}
				}
				echo "[+] Removed '$nb/$nb_old' old records of WhiteList (# of records was 0)\n";
			}

			unset($genders_detected[Gender::GENDER_BOTH]);

			$new_gender = $brand->gender;

			if (Gender::GENDER_BOTH == $brand->gender) {
				if (count($genders_detected) == 1) {
					$new_gender = array_keys($genders_detected)[0];
				}
			} else {
				if (1 != count($genders_detected)) {
					$new_gender = Gender::GENDER_BOTH;
				}
			}

			if ($new_gender != $brand->gender) {
				$brand->gender = $new_gender;
				$brand->save();

				echo "[+] Brand ({$brand->slug}) is now ({$brand->gender}) only\n";
			}
		}

		return true;
	}
}

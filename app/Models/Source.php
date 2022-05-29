<?php

namespace App\Models;

use Ajgl\Csv\Rfc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Source extends Model implements Sortable
{
    use SortableTrait;

    const CONFIG_TIMEOUT = 'timeout';

    const CONFIG_COL_SEPARATOR = 'col_separator';

    const CONFIG_CSV_HEADERS = 'csv - headers';

    const CONFIG_XML_UNIQUENODE = 'xml - uniqueNode';

    const CONFIG_XML_NAMESPACE = 'xml - nameSpace';

    const CONFIG_FORCE_BRAND_NAME = 'force - brand name';

    const CONFIG_FORCE_GENDER = 'force - gender';

    const CONFIG_FIX_UTF8 = 'fix - utf8';

    const CONFIG_APPEND_CATEGORY = 'append - category';

    const CONFIG_TRANSFORM_URL = 'transform - url';

    const CONFIG_STR_REPLACE_IMAGE = 'str_replace - image_url';

    const CONFIG_CONVERT_CURRENCY_FROM = 'convert - currency - from';

    const CONFIG_PRESTASHOP_LANGUAGE = 'prestashop - language';

    const CONFIG_PRESTASHOP_LANGUAGE_ID = 'prestashop - language id';

    const CONFIG_PRESTASHOP_IMAGE_TYPE = 'prestashop - image type';

    public $guarded = [];

    public $col_sep = ',';
    // TODO: rename this column_seperator

    protected $attributes = [
        'enabled' => false,
        'nb_of_products' => 0,
    ];

    public $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => true,
    ];

    public static $headers = null;

    public static $columns = [
        'name',
        'slug',
        'description',
        'price',
        'old_price',
        'reduction',
        'url',
        'merchant_original',
        'brand_original',
        'category_original',
        'gender',
        'currency_original',
        'color_original',
        'image_url',
        'provider',
        'col',
        'coupe',
        'manches',
        'material',
        'model',
        'motifs',
        'event',
        'style',
        'size',
        'livraison',
        'payload',
        'i',
    ];

    protected $casts = [
        'config' => 'json',
    ];

    const PARSERS = [
        Parsers\Awin::class,
        Parsers\CJ::class,
        Parsers\Partnerize::class,
        Parsers\NetaffiliationV3::class,
        Parsers\NetaffiliationV4::class,
        Parsers\Tradedoubler::class,
        Parsers\Tradetracker::class,
        Parsers\Rakuten::class,
        Parsers\Daisycon::class,
        Parsers\Effiliation::class,
        Parsers\Shopify::class,
        Parsers\Woocommerce::class,
        Parsers\Flexoffers::class,
        Parsers\Wix::class,
        Parsers\Prestashop::class,
        Parsers\Impact::class,
    ];

    private static $i = 1;

    private $reasons_for_skipping = [];

    private $categories_added = [];

    private $brands_added = [];

    // TODO: remove these 3 magic methods
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('parser', function (Builder $builder) {
            if (isset(static::$parser)) {
                $builder->where('parser', '=', static::$parser);
            }
        });
    }

    public function newInstance($attributes = [], $exists = false, $class = null)
    {
        if (null === $class) {
            $class = static::class;
        }
        $model = new $class((array) $attributes);
        $model->exists = $exists;
        $model->setConnection($this->getConnectionName());

        return $model;
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $class = static::class;
        foreach (self::PARSERS as $parser_class) {
            if ($parser_class::$parser == $attributes->parser) {
                $class = $parser_class;
            }
        }

        $model = $this->newInstance([], true, $class);
        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    public static function getColumnsAsString()
    {
        return implode(',', static::$columns);
    }

    public function getTable()
    {
        if (! isset($this->table)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename(self::class))));
        }

        return $this->table;
    }

    public function save(array $options = [])
    {
        if (empty($this->title)) {
            $this->title = $this->name;
        }

        if (empty($this->parser)) {
            $this->parser = trim(explode(' ', $this->name)[0]);
        }

        $this->config = array_filter($this->config ?: []);

        return parent::save($options);
    }

    public function psql_command($new_table)
    {
        return 'psql "'.config('database.database_url').'" -c '.
            '"COPY '.$new_table.'('.self::getColumnsAsString().") FROM STDIN DELIMITER ',' CSV".'"';
    }

    public function download_feed_command()
    {
        $command = "curl --globoff --header 'user-agent: modalova' --insecure --cookie 'allow-download=1' --location --silent ";

        if (Parsers\Rakuten::$parser == $this->parser) {
            $command .= ' --ignore-content-length ';
        }

        $command .= ' '.escapeshellarg($this->path);

        if (false !== strpos($this->path, 'compression/gzip') || false !== strpos($this->path, '.gz')) {
            $command .= ' | gunzip';
        }
        if (false !== strpos($this->path, '.zip')) {
            $command .= ' | funzip';
        }

        if ($fix_utf8 = boolval(@$this->config[self::CONFIG_FIX_UTF8])) {
            $command .= ' | iconv -c -f UTF-8 -t ISO-8859-1 ';
        }

        return $command;
    }

    public static function array_combine($keys, $values)
    {
        error_log('Source::array_combine has been deprecated');

        return Fetchers\CSV::array_combine($keys, $values);
    }

    public function getHeaders()
    {
        $headers = static::$headers;

        if ($_headers = @$this->config[self::CONFIG_CSV_HEADERS]) {
            $headers = mb_split('[,;|]', $_headers);
        }

        return $headers;
    }

    public function getFetcher($handle)
    {
        if ($col_sep = @$this->config[self::CONFIG_COL_SEPARATOR]) {
            $this->col_sep = $col_sep;
        }

        // TODO: allow for the parser to be overriden by admin using the `config` array instead of guessing

        if (false !== strpos($this->path, '.json') || false !== strpos($this->path, '=JSON')) {
            $fetcher = new Fetchers\Json($handle);
        } elseif (false !== stripos($this->name, 'xml') || false !== stripos($this->path, '.xml')) {
            $fetcher = new Fetchers\Xml($handle, [
                'uniqueNode' => @$this->config[self::CONFIG_XML_UNIQUENODE],
                'nameSpace' => @$this->config[self::CONFIG_XML_NAMESPACE],
            ]);
        } else {
            $fetcher = new Fetchers\CSV($handle, [
                'col_sep' => $this->col_sep,
                'headers' => $this->getHeaders(),
            ]);
        }

        return $fetcher;
    }

    public function import($new_table)
    {
        $progress_good = 0;
        $progress_bad = 0;

        $time_0 = hrtime(true);
        \Log::info("[+] Importing ($this->id) '$this->name' into '$new_table'");

        if (! $process = proc_open($this->psql_command($new_table), [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes)) {
            \Log::err("[-] ERROR: Could not import ($this->id) '$this->name' ($process)");

            return $process;
        }

        $timeout = ($this->config[self::CONFIG_TIMEOUT] ?? 15).'m';

        $start = date(DATE_RSS);

        if (! $handle = popen('timeout '.$timeout.' '.$this->download_feed_command(), 'r')) {
            \Log::err("[-] ERROR: Could not open handle ($handle)");

            return $handle;
        }
        \Log::debug("[+] Downloaded: $this->path");

        if (! $fetcher = $this->getFetcher($handle)) {
            return;
        }

        try {
            $fetcher->parse(function ($row) use (&$pipes, &$progress_good, &$progress_bad) {
                static $progress = ['▁', '▃', '▄', '▅', '▆', '▇', '█', '▇', '▆', '▅', '▄', '▃'];
                try {
                    if (! $data = $this->parse_row($row)) {
                        $progress_bad++;
                    } else {
                        array_push($data, self::$i++);

                        Rfc\fputcsv($pipes[0], $data);
                        $progress_good++;
                    }

                    if ('local' == config('app.env')) {
                        echo "\r\t".current($progress).'    i:'.self::$i."    good:$progress_good    bad:$progress_bad    ";

                        if (0 == self::$i % 100 && false === next($progress)) {
                            reset($progress);
                        }
                    }
                } catch (\Exception $e) {
                    \Log::debug([
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);

                    app('sentry')->captureException($e);
                }
            });
        } catch (\Exception $e) {
            \Log::debug([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            app('sentry')->captureException($e);
        }

        if ('local' == config('app.env')) {
            echo "\n";
        }

        $termination_status = pclose($handle);
        fclose($pipes[0]);

        $this->nb_of_products = $progress_good;

        $this->extra = explode('--', $this->extra, 2)[0];
        $this->extra .= '--';
        $this->extra .= "\nSTART: ".$start;
        $this->extra .= "\nEND: ".date(DATE_RSS);
        $this->extra .= "\nTERMINATION_STATUS: ".$termination_status;
        $this->extra .= "\ngood:$progress_good bad:$progress_bad";
        $this->extra .= "\nheaders: ".print_r($fetcher->headers ?? $this->getHeaders(), true);
        $this->extra .= "\nreasons_for_skipping: ".print_r($this->reasons_for_skipping, true);
        $this->extra .= "\nbrands_added: ".print_r(array_unique($this->brands_added), true);
        $this->extra .= "\ncategories_added: ".print_r(array_values(array_filter(array_unique($this->categories_added))), true);
        $this->save();

        $time_1 = hrtime(true);
        $diff_1 = ($time_1 - $time_0) / 1000000000;
        \Log::info("[+] Imported ($this->id) '$this->name' in [$diff_1]. i:".self::$i." good:$progress_good bad:$progress_bad");

        $output_1 = trim(stream_get_contents($pipes[1]));
        fclose($pipes[1]);

        $output_2 = trim(stream_get_contents($pipes[2]));
        fclose($pipes[2]);

        if (false === preg_match('/^COPY /', $output_1) && empty($output_2)) {
            \Log::debug('[-] DB ERROR: '.$output_1.' / '.$output_2);
            app('sentry')->captureMessage("1: $output_1\n2: $output_2");
        }

        return proc_close($process);
    }

    protected function before_parse_row($row)
    {
        return $row;
    }

    protected function after_parse_row($array, $row)
    {
        // merchant_original
        $array[7] = str_ireplace([
            'affiliation',
            'standard',
        ], '', $array[7]);
        $array[7] = trim(preg_replace('/(?: -)?(?: \(?[A-Z]{2,3}\)?)+$/', '', $array[7]));

        // color_original
        $array[12] = implode(
            Product::FACET_SEPARATOR,
            array_filter(
                explode(Product::FACET_SEPARATOR, $array[12]),
                function ($str) {
                    return ! ctype_digit($str);
                }
            )
        );

        // image_url
        $array[13] = str_replace([
            'https:/image',
            'http://img.ltwebstatic.com/',
            '_09_74x102.jpg?', // Sarenza
        ], [
            'https://image',
            'https://img.ltwebstatic.com/',
            '_09_504x690.jpg?',
        ], $array[13]);

        if (($map_config_str_replace_image = @$this->config[self::CONFIG_STR_REPLACE_IMAGE])
            && (1 != @$row['marketplace']) // Skip this for product from Spartoo marketplace (images are not HD)
        ) {
            $rules = explode("\n", $map_config_str_replace_image);

            foreach ($rules as $rule) {
                list($op1, $op2) = explode('=', $rule);
                $op1 = trim($op1);
                $op2 = trim($op2);

                $array[13] = str_replace($op1, $op2, $array[13]);
            }
        }

        // sizes
        $array[23] = mb_strtoupper($array[23]);

        return $array;
    }

    private function clean_string($string)
    {
        $string = str_replace('\\\'', "'", $string);
        $string = str_replace('\\"', '"', $string);
        $string = strip_tags($string);
        $string = trim($string);

        return $string;
    }

    public function parse_row($row)
    {
        $row = $this->before_parse_row($row);

        $product_name = $this->guess_product_name($row);

        if (! $brand_name = @$this->config[self::CONFIG_FORCE_BRAND_NAME]) {
            $brand_name = $this->guess_brand_name($row);
        }

        $price = $this->guess_price($row);
        $old_price = $this->guess_old_price($row);

        if ($price == $old_price) {
            $old_price = 0;
        }

        if (0 == $price) {
            $price = $old_price;
            $old_price = 0;
        }

        if ($old_price && $price > $old_price) {
            $temp = $price;
            $price = $old_price;
            $old_price = $temp;
        }

        if ($convert_currency_from = @$this->config[self::CONFIG_CONVERT_CURRENCY_FROM]) {
            $rate = 0.8397188752; // USD

            $price *= $rate;
            $old_price *= $rate;
        }

        $price = round($price, 2);
        $old_price = round($old_price, 2);

        $reduction = ($old_price > 0) ? round((1 - ($price / $old_price)) * 100) : 0;

        $description = $this->guess_description($row);
        $description = substr($description, 0, 10000);

        $url = $this->guess_url($row);
        if ($url_transformer = @$this->config[self::CONFIG_TRANSFORM_URL]) {
            $url = str_replace([
                '{url}',
                '{url_encoded}',
            ], [
                $url,
                urlencode($url),
            ], $url_transformer);
        }

        $merchant = $this->guess_merchant($row);
        $currency = $this->guess_currency($row);
        $image_url = $this->guess_image_url($row);
        $categories = $this->guess_categories($row);

        if (! $gender = @$this->config[self::CONFIG_FORCE_GENDER]) {
            $gender = $this->guess_gender($row);
        }

        $colors = $this->guess_colors($row);
        $sizes = $this->guess_sizes($row);
        $manches = $this->guess_manches($row);
        $cols = $this->guess_cols($row);
        $coupes = $this->guess_coupes($row);
        $motifs = $this->guess_motifs($row);
        $events = $this->guess_events($row);
        $materials = $this->guess_materials($row);
        $livraison = $this->guess_livraison($row);
        $models = $this->guess_models($row);
        $styles = $this->guess_styles($row);

        if (0 == $price) {
            return $this->add_reason_for_skipping('no price');
        }

        if (empty($url)) {
            return $this->add_reason_for_skipping('no url');
        }

        if (empty($product_name)) {
            return $this->add_reason_for_skipping('no product_name');
        }

        if ($this->should_I_skip_this_row($row)) {
            return false;
        }

        if (strlen($product_name) > 35) {
            if (! empty($colors)) {
                foreach (explode('|', $colors) as $color) {
                    $color = str_replace('/', '\/', preg_quote($color));
                    $product_name = preg_replace('/(?<!\w)'.$color.'e?s?(?!\w)/i', '', $product_name);
                }
            }

            if (! empty($brand_name)) {
                $product_name = str_ireplace($brand_name, '', $product_name);
            }

            if (! empty($gender)) {
                $product_name = str_ireplace(' pour '.$gender, '', $product_name);
                $product_name = str_ireplace($gender, '', $product_name);
            }
        }

        // \p{L} matches every unicode character from every alphabet, so accents too
        $product_name = preg_replace('/^[^\p{L}]+/i', '', $product_name);  // remove whitespaces at the beginning
        // Capitalize only first letter, leave other uppercase letters alone
        $product_name = mb_ucfirst($product_name);
        $product_name = preg_replace('/\s+-\s+$/i', '', $product_name);  // remove trailing dashes (with potential surrounding whitespaces)
        $product_name = preg_replace('/ {2,}/', ' ', $product_name);  // remove multiple whitespaces
        $product_name = trim($product_name);
        $product_name = trim($product_name, ',.-');

        $product_name = substr($product_name, 0, 250);

        $product_name = $this->clean_string($product_name);
        $description = $this->clean_string($description);
        $categories = $this->clean_string($categories);

        $product_name = html_entity_decode($product_name, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401);
        $description = html_entity_decode($description, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401);
        $brand_name = html_entity_decode($brand_name, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401);

        $slug = $this->guess_slug($row);
        if (strlen($slug) > 250) {
            $slug = substr($slug, 0, 250);
        }

        if (empty($merchant)) {
            $merchant = $this->title;
        }
        if (empty($brand_name)) {
            $brand_name = $merchant;
        }

        if (config('imports.SHOW_DEBUG')) {
            if (! isset($this->brands_added[$brand_name])) {
                $this->brands_added[$brand_name] = 0;
            }

            $this->brands_added[$brand_name]++;

            $this->categories_added = array_merge(
                $this->categories_added,
                explode(Product::FACET_SEPARATOR, $categories)
            );
        }

        return $this->after_parse_row([
            $product_name,  //  0 - name
            $slug,          //  1 - slug
            $description,   //  2 - description
            $price,         //  3 - price
            $old_price,     //  4 - old_price
            $reduction,     //  5 - reduction
            $url,           //  6 - url
            $merchant,      //  7 - merchant_original
            $brand_name,    //  8 - brand_original
            $categories,    //  9 - category_original
            $gender,        // 10 - gender
            $currency,      // 11 - currency_original
            $colors,        // 12 - color_original
            $image_url,     // 13 - image_url
            $this->name,    // 14 - provider
            $cols,          // 15 - cols
            $coupes,        // 16 - coupes
            $manches,       // 17 - manches
            $materials,     // 18 - materials
            $models,        // 19 - models
            $motifs,        // 20 - motifs
            $events,        // 21 - events
            $styles,        // 22 - styles
            $sizes,         // 23 - sizes
            $livraison,     // 24 - livraison
            config('imports.PRODUCT_STORE_PAYLOAD') ? base64_encode(json_encode(array_merge($row, [
                'import__extra' => [
                    'source__id' => $this->id,
                    'source__name' => $this->name,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ]))) : '', // payload
        ], $row);
    }

    protected function __guess_slug($row, $id)
    {
        return $this->__guess_slug_real($this->guess_product_name($row), $id);
    }

    protected function __guess_slug_real($product_name, $product_id)
    {
        return slugify($product_name.'-'.$product_id);
    }

    protected function __guess_gender($row, $gender)
    {
        if (empty($gender)) {
            $gender = $this->__guess_gender_from_string($this->guess_categories($row));
        }
        if (empty($gender)) {
            $gender = $this->__guess_gender_from_string($this->guess_product_name($row));
        }

        $gender = $this->__guess_string($gender);

        return $gender ?: Gender::GENDER_BOTH;
    }

    protected function __guess_categories($values)
    {
        $values = array_map(function ($value) {
            if (ctype_digit((string)$value)) {
                // TODO: only do the ::find() on last call ; or store value to prevent multiples calls
                if ($category_from_google = GoogleProductCategory::find($value)) {
                    return $category_from_google->name;
                }

                return null;
            }

            return $value;
        }, $values);

        if ($category_to_append = @$this->config[self::CONFIG_APPEND_CATEGORY]) {
            $values[] = $category_to_append;
        }

        $value = $this->__guess_multi_string($values);

        return $value;
    }

    protected function guess_merchant($row)
    {
        return $this->__guess_string($this->title);
    }

    protected function guess_models($row)
    {
        return null;
    }

    protected function guess_styles($row)
    {
        return null;
    }

    protected function guess_currency($row)
    {
        // TODO: read this from feed and allow conversion from USD to EUR
        return config('app.currency');
    }

    protected function guess_age_group($row)
    {
        $brand_name = $this->guess_brand_name($row);

        foreach ([
            'kids',
        ] as $needle) {
            if (false !== stripos($brand_name, $needle) || false !== stripos($brand_name, _i($needle))) {
                return 'kids';
            }
        }

        return mb_strtolower((string)@$row['age_group']);
    }

    private function get_values_for_string_matching($row)
    {
        return $value = implode(' ', [
            $this->guess_product_name($row),
            $this->guess_description($row),
            $this->guess_categories($row),
        ]);
    }

    protected function guess_cols($row)
    {
        $value = $this->get_values_for_string_matching($row);

        return $this->__guess_cols($value);
    }

    protected function guess_coupes($row)
    {
        $value = $this->get_values_for_string_matching($row);

        return $this->__guess_coupes($value);
    }

    protected function guess_manches($row)
    {
        $value = $this->get_values_for_string_matching($row);

        return $this->__guess_manches($value);
    }

    protected function guess_motifs($row)
    {
        $value = $this->get_values_for_string_matching($row);

        return $this->__guess_motifs($value);
    }

    protected function guess_events($row)
    {
        $value = $this->get_values_for_string_matching($row);

        return $this->__guess_events($value);
    }

    protected function __guess_string($value)
    {
        $value = trim((string)$value);

        return empty($value) ? '' : $value;
    }

    protected function __guess_multi_string($values)
    {
        return empty($values) ? '' : mb_strtolower(implode(Product::FACET_SEPARATOR, array_filter(array_unique($values))));
    }

    protected function __guess_float($value)
    {
        return empty($value) ? 0 : floatval($value);
    }

    protected function __guess_gender_from_string($string)
    {
        if (empty($string)) {
            return false;
        }

        $string = mb_strtolower($string);

        $value = false;

        if (
            'f' == $string
          || false !== strpos($string, 'femme')
          || false !== strpos($string, 'woman')
          || false !== strpos($string, 'women')
          || false !== strpos($string, 'female')
          || false !== strpos($string, 'femelle')
          || false !== strpos($string, '|women|')
          || false !== strpos($string, _i('femme'))
        ) {
            $value = Gender::GENDER_FEMALE;
        } elseif (
            'h' == $string
          || 'mens' == $string
          || false !== strpos($string, 'homme')
          || false !== strpos($string, 'male')
          || false !== strpos($string, 'man >')
          || false !== strpos($string, 'men >')
          || false !== strpos($string, '|mens|')
          || false !== strpos($string, '|men|')
          || false !== strpos($string, _i('homme'))
        ) {
            $value = Gender::GENDER_MALE;
        } elseif (
            false !== strpos($string, 'fille')
          || false !== strpos($string, 'girl')
          || false !== strpos($string, _i('fille'))
        ) {
            $value = Gender::GENDER_GIRL;
        } elseif (
            false !== strpos($string, 'garçon')
          || false !== strpos($string, 'garcon')
          || false !== strpos($string, _i('garçon'))
        ) {
            $value = Gender::GENDER_BOY;
        } elseif (
            false !== strpos($string, 'enfant')
          || false !== strpos($string, _i('enfant'))
          || false !== strpos($string, 'kid')
          || false !== strpos($string, 'kids')
        ) {
            $value = Gender::GENDER_CHILD;
        } elseif (
            false !== strpos($string, 'unisex')
          || false !== strpos($string, _i('unisex'))
          || false !== strpos($string, 'mixte')
          || false !== strpos($string, _i('mixte'))
        ) {
            $value = Gender::GENDER_BOTH;
        }

        return $value;
    }

    protected function __guess_cols($string)
    {
        $values = [];

        // TODO: store these values in DB and allow admin to change them
        $values = array_merge($values, $this->simple_match($string, [
            'col à fronces' => null,
            'col à revers' => null,
            'col à nouer' => null,
            'col amovible' => null,
            'col asymétrique' => null,
            'col bardot' => null,
            'col bateau' => null,
            'col bénitier' => null,
            'col blouse' => null,
            'col camionneur' => null,
            'col châle' => null,
            'col cheminée' => null,
            'col classique' => null,
            'col claudine' => null,
            'col double' => null,
            'col droit' => null,
            'col escargot' => null,
            'col fauve' => null,
            'col fourré' => null,
            'col français' => null,
            'col italien' => null,
            'col lacé' => null,
            'col mao' => null,
            'col mandarin' => null,
            'col médicis' => null,
            'col montant' => null,
            'col ouvert' => null,
            'col pointu' => null,
            'col tunisien' => null,
            'col romain' => null,
            'col roulé' => null,

            'col écharpe' => 'col écharpe',
            'col echarpe' => 'col écharpe',

            'col boutonné' => 'col boutonné',

            'col v' => 'col v',
            'col en v' => 'col v',

            'col rond' => 'col rond',
            'encolure rond' => 'col rond',

            'col lavallière' => 'col lavallière',
            'col à lavallière' => 'col lavallière',
        ]));

        return $this->__guess_multi_string($values);
    }

    protected function __guess_coupes($string)
    {
        $values = [];

        $values = array_merge($values, $this->simple_match($string, [
            'coupe oversize' => null,
            'coupe croisée' => null,
            'coupe standard' => null,
            'coupe ample' => null,
            'coupe longue' => null,
            'coupe ajustée' => null,

            'coupe slim' => 'coupe cintrée/slim',
            'coupe cintrée' => 'coupe cintrée/slim',

            'coupe droite' => 'coupe classique/droite',
            'coupe classique' => 'coupe classique/droite',
        ]));

        return $this->__guess_multi_string($values);
    }

    protected function __guess_manches($string)
    {
        $values = [];

        $values = array_merge($values, $this->simple_match($string, [
            'sans manche' => null,

            'manches longue' => 'manches longues',
            'manche longue' => 'manches longues',

            'manches courte' => 'manches courtes',
            'manche courte' => 'manches courtes',

            'manches volant' => 'manche volant',
            'manche volant' => 'manche volant',
        ]));

        return $this->__guess_multi_string($values);
    }

    protected function __guess_motifs($string)
    {
        $values = [];

        $values = array_merge($values, $this->simple_match($string, [
            'motif monogrammé' => null,
            'motif à pois' => null,
            'motif zig-zag' => null,
            'motif moucheté' => null,
            'motif cachemire' => null,
            'motif navajo' => null,
            'motif intarsia' => null,
            'motif losange' => null,
            'motif chevron' => null,

            'pied de poule' => 'motif pied de poule',
            'pied-de-poule' => 'motif pied de poule',

            'motif à rayures' => 'motif à rayures',
            'motif de rayures' => 'motif à rayures',

            'motif géométrique' => 'motif géométrique',
            'motif à formes géométriques' => 'motif géométrique',

            'motif à carreaux' => 'motif à carreaux',
            'imprimé à carreaux' => 'motif à carreaux',

            'floral' => 'motif floral',
            'de fleurs' => 'motif floral',
            'à fleurs' => 'motif floral',
        ]));

        return $this->__guess_multi_string($values);
    }

    protected function __guess_events($string)
    {
        $values = [];

        $values = array_merge($values, $this->simple_match($string, [
            'soirée chic' => null,

            'plage' => 'plage',

            'de mariage' => 'mariage',
            'un mariage' => 'mariage',
            'demoiselle d\'honneur' => 'mariage',
        ]));

        return $this->__guess_multi_string($values);
    }

    protected function __guess_materials($string)
    {
        $values = [];

        $string = remove_accents($string);
        $string = str_replace('&amp;', '', (string)$string);

        if (preg_match_all('/% ([\w\s]+)/', $string, $matches) > 0) {
            $values = array_merge($values, $matches[1]);
        } else {
            $values = array_merge($values, $this->handle_multiple_values($string));
        }

        $values = array_map(function ($v) {
            $chunks = explode(':', $v);

            if (false !== stripos($chunks[0], 'MDL') || false !== stripos($chunks[0], 'FDA')) {
                return null;
            }

            $c = preg_replace('/[0-9]{0,3}%/', '', end($chunks));

            if (false !== stripos($c, 'alcohol denat')) {
                return null;
            }

            return trim($c);
        }, $values);

        return $this->__guess_multi_string($values);
    }

    protected function simple_match($string, $rules)
    {
        $values = [];

        $string = mb_strtolower($string);

        foreach ($rules as $search => $value) {
            if (null === $value) {
                $value = $search;
            }

            if (false !== strpos($string, $search)) {
                $values[] = $value;
            }
        }

        return $values;
    }

    protected function handle_multiple_values($value, $pattern = '/[,;\/\-&]/')
    {
        if (empty($value)) {
            return [];
        }

        if (! is_array($value)) {
            $value = preg_split($pattern, $value, -1, PREG_SPLIT_NO_EMPTY);
        }

        return array_map('trim', $value);
    }

    private function add_reason_for_skipping($reason)
    {
        if (! isset($this->reasons_for_skipping[$reason])) {
            $this->reasons_for_skipping[$reason] = 0;
        }

        $this->reasons_for_skipping[$reason]++;

        if ('local' == config('app.env')) {
            echo str_pad($reason, 80);
        }

        return false;
    }

    protected function should_I_skip_this_row($row)
    {
        if (in_array($this->guess_age_group($row), ['kids', 'enfants'])) {
            $this->add_reason_for_skipping('for kids');

            return true;
        }

        if ($this->category_is_not_fashion($row)) {
            $this->add_reason_for_skipping('not fashion ('.$this->guess_categories($row).')');

            return true;
        }

        if ($this->product_is_not_available($row)) {
            $this->add_reason_for_skipping('not available');

            return true;
        }

        if (empty($this->guess_image_url($row))) {
            $this->add_reason_for_skipping('no image');

            return true;
        }

        if (false !== strpos($this->guess_image_url($row), 'noimage')) {
            $this->add_reason_for_skipping('bad image');

            return true;
        }

        if (! in_array($this->guess_gender($row), Gender::genders())) {
            $this->add_reason_for_skipping('bad gender ('.$this->guess_gender($row).' / '.$this->guess_categories($row).')');

            return true;
        }

        return false;
    }

    protected function product_is_not_available($row)
    {
        foreach ([
            'availability',
            'disponibilite',
        ] as $key) {
            if (isset($row[$key])) {
                if (in_array($row[$key], [
                    'out of stock',
                ])) {
                    return true;
                }
            }
        }

        foreach ([
            'stock_quantity',
            'active',
        ] as $key) {
            if (isset($row[$key])) {
                if ('0' == $row[$key]) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function category_is_not_fashion($row)
    {
        $categories = $this->guess_categories($row);

        // TODO: store these values in DB and allow admin to change them
        foreach ([
            'modalova__do-not-import-me__modalova',

            'érotisme',

            'maison',
            'meuble',
            'homeware',
            'drinkware',
            'garden',
            'intelligence',
            'security',
            'lifestyle',
            'jardinage',
            'plein air',
            'garage',
            'extérieur',
            'aménagement',
            'rangements',
            'cuisine',
            'kitchen',
            'literie',
            'oreiller',

            'Books',
            'littérature',

            'petit garçon',
            'kid garçon',
            'petite fille',
            'kid fille',
            'enfant',
            'bébé',
            'fille',
            'adolescent',
            'naissance',
            'baby',
            'toddler',

            'visage + corps',
            'soin du corps',
            'soins',
            'skincare',
            'beauté',
            'beaute',
            'beauty',
            'parfum',
            'fragrance',
            'maquillage',
            'cosmetics',
            'démaquillant',

            'vin rouge',

            'automóvil',
            'motocicleta',
            'reptiles',
            'activités sportives',
            'equipments',
            'high tech',
            'vélo',
            'pièces détachées',
            'loisirs',

            'décoration',
            'papeterie',
            'fourniture',

            'électronique',
            'électroménager',

            'mamelon',
            'intimate toy',
            'jouet',
            'jeux',
            'figurine',
            'puériculture',
            'gastronomie',

            'gift card',
        ] as $needle) {
            if (false !== stripos($categories, $needle) || false !== stripos($categories, _i($needle))) {
                return true;
            }
        }

        return false;
    }
}

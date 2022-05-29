<?php

namespace App\Models\Parsers;

use App\Models\Gender;
use App\Models\Product;

class Awin extends \App\Models\Source
{
    public static $parser = 'awin';

    protected $__fields_for_category = [
        'merchant_product_category_path',
        'merchant_product_second_category',
        'merchant_product_third_category',
        'merchant_category',
        'category_name',
        'product_type',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(!empty($this->path)) {
            if (1 === preg_match('/\/delimiter\/\%([A-Z0-9]{2})\//', $this->path, $matches)) {
                $this->col_sep = hex2bin($matches[1])[0];
            }
        }
    }

    protected function after_parse_row($array, $row)
    {
        $array = parent::after_parse_row($array, $row);

        if (preg_match('/^(.+) - - ([0-9]+|[XSML]{1,3}|taille unique|one size)$/i', $array[0], $matches)) {
            // name
            $array[0] = $matches[1];

            // sizes
            $array[23] .= Product::FACET_SEPARATOR.mb_strtoupper($matches[2]);
            $array[23] = trim($array[23], Product::FACET_SEPARATOR);
        }

        // generate slug with final $product_name
        $array[1] = $this->__guess_slug_real($array[0], $this->__get_product_id($row));

        // we remove these values from 'description' so that duplicates can be detected
        foreach ([
            12, // colors
            23, // sizes
        ] as $key) {
            $array[2] = str_ireplace(
        array_map(function ($v) {
            return " $v ";
        }, explode(Product::FACET_SEPARATOR, $array[$key])), ' ',
        $array[2]
      );
        }

        return $array;
    }

    private function __get_product_id($row)
    {
        $id = @$row['parent_product_id'];
        if (empty($id)) {
            $id = @$row['aw_product_id'];
        }

        return $id;
    }

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, $this->__get_product_id($row));
    }

    protected function guess_url($row)
    {
        return @$row['aw_deep_link'];
    }

    protected function guess_merchant($row)
    {
        return @$row['merchant_name'];
    }

    protected function guess_product_name($row)
    {
        $value = @$row['product_name'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['brand_name'];

        if ('ARMOR LUX FR' == @$row['merchant_name']) {
            $value = '';
        }

        if (empty($value)) {
            $value = preg_replace('/ FR$/', '', @$row['merchant_name']);
        }

        return $this->__guess_string($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['description'];

        if ('15341' == @$row['data_feed_id'] && '7375' == @$row['merchant_id']) { // Tostadora
            $value = @$row['product_short_description'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['search_price'];
        }
        if (empty($value)) {
            $value = @$row['rrp_price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['product_price_old'];
        }
        if (empty($value)) {
            $value = @$row['base_price'];
        }
        if (empty($value)) {
            $value = @$row['rrp_price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_gender($row)
    {
        $value = null;

        if (in_array($row['brand_name'], [
            'Etam',
            'Envie de Fraise',
            'Nasty Gal',
        ])) {
            return Gender::GENDER_FEMALE;
        }

        if (in_array($row['merchant_name'], [
            'JW PEI FR',
        ])) {
            return Gender::GENDER_FEMALE;
        }

        $description = $this->guess_description($row);

        if (false !== strpos($description, 'la mannequin')) {
            return Gender::GENDER_FEMALE;
        }

        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Fashion:suitable_for']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['custom_1']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['custom_5']);
        } // Under Armour
        if (empty($value)) {
            foreach ($this->__fields_for_category as $field) {
                if (empty($value)) {
                    $value = $this->__guess_gender_from_string(@$row[$field]);
                }
            }
        }

        if ('Jacques Loup FR' == @$row['merchant_name']) {
            if (empty($value)) {
                $value = $this->__guess_gender_from_string(@$row['product_name']);
            }
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['aw_image_url'];

        if (empty($value)) {
            $value = @$row['merchant_image_url'];
        }

        if (! empty($row['large_image'])) {
            if ('15255' == @$row['data_feed_id'] && '7342' == @$row['merchant_id']) { // Boohoo
                $value = explode('$', @$row['large_image'])[0];
            } elseif ('yoox_fr' == @$row['merchant_name']) {
                $value = @$row['large_image'];
            }
        }

        if ('Jacques Loup' == $this->guess_brand_name($row)) {
            $value = str_replace('ssl%3A', 'https%3A%2F%2F', $value);
            parse_str(parse_url($value, PHP_URL_QUERY), $result);

            if ($urls = $result['url']) {
                $urls = explode(',', $urls);
                $value = $urls[0];
            }
        }

        return empty($value) ? '' : preg_replace('/([w|h])=[0-9]+/', '$1=1000', $value);
    }

    protected function guess_categories($row)
    {
        $values = [];

        if ('15341' == @$row['data_feed_id'] && '7375' == @$row['merchant_id']) { // Tostadora
            $values[] = 'vêtements > t-shirt';
        }

        if ('18025' == @$row['data_feed_id'] && '9173' == @$row['merchant_id']) { // PrettyLittleThing
            $values[] = @$row['custom_4'];
        }

        if ('NastyGal FR' == @$row['merchant_name']) {
            $values[] = @$row['size_stock_amount'];
        }

        if (in_array(@$row['brand_name'], [
            'TFNC',
            'TFNC Tall',
            'TFNC Plus',
            'TFNC Maternity',
            'TFNC Petite',
            'Envie de Fraise',
        ])) {
            $values[] = 'vêtements';
        }

        foreach ($this->__fields_for_category as $field) {
            $values[] = @$row[$field];
        }

        return $this->__guess_categories($values);
    }

    protected function guess_livraison($row)
    {
        $value = @$row['delivery_time'];

        return $this->__guess_string($value);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['colour']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['Fashion:size']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        $value = @$row['Fashion:material'];

        if (empty($value)) {
            return '';
        }

        if ('Boden FR' == @$row['merchant_name']) {
            return '';
        }

        if ('Scotch&Soda FR' == @$row['merchant_name']) {
            if ($data = json_decode($value)) {
                return $this->__guess_multi_string(array_keys(get_object_vars($data)));
            }
        }

        return $this->__guess_materials($value);
    }
}

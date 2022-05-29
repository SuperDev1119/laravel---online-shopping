<?php

namespace App\Models\Parsers;

class Tradedoubler extends \App\Models\Source
{
    public static $parser = 'tradedoubler';

    public $col_sep = '|';

    private $__fields_for_colors = [
        '(field)Color',
        '(field)color',
    ];

    private $__description_properties = [
        'Manche:',
        'Matériel:',
    ];

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['sku']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['name'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['brand'];

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['(field)Sale Price'];
        }
        if (empty($value)) {
            $value = @$row['priceValue'];
        }
        if (empty($value)) {
            $value = @$row['price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = @$row['priceValue'];

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['description'];

        $value = preg_replace_callback('/(&#[0-9]+;)/', function ($m) {
            return mb_convert_encoding($m[1], 'UTF-8', 'HTML-ENTITIES');
        }, $value);

        foreach ($this->__description_properties as $prop) {
            $value = str_replace($prop, "\n{$prop}", $value);
        }

        $min = 'a-zàâäèéêëîïôœùûüÿç';
        $max = 'A-ZÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ';

        $value = preg_replace(
      '#(['.$min.']|[1-9]XL+|[0-9]+%)(['.$max.'])(?=[0-9'.$max.''.$min.'\-‎\'\s\(\)/]*:)#u',
      "$1\n$2",
      htmlspecialchars_decode($value)
    );

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = @$row['productUrl'];

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['programName'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['(field)gender']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['(field)Age Group']);
        } // fix a misconfiguration from vendors
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['categories']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = trim(@$row['productImage'], ':;');

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = @$row['deliveryTime'];

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = explode(';', @$row['categories']);

        if (! empty($row['(field)subcategory'])) {
            $values[] = $row['(field)subcategory'];
        }

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];

        foreach ($this->__fields_for_colors as $field) {
            if (! empty($row[$field])) {
                $values = array_merge($values, $this->handle_multiple_values($row[$field]));
            }
        }

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['size']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        return $this->__guess_materials(@$row['(field)composition']);
    }
}

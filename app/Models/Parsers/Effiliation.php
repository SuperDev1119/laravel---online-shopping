<?php

namespace App\Models\Parsers;

use App\Models\Gender;

class Effiliation extends \App\Models\Source
{
    public static $parser = 'effiliation';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['id']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['title'];

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
            $value = @$row['price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['price_norebate'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['description'];

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = @$row['link'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['gender']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['image_link'];

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = @$row['shipping_time'];
        if (! empty($value) && is_numeric($value)) {
            $value .= ($value > 1) ? ' days' : ' day';
        }

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        foreach ([
            'category',
            'category_level2',
            'category_level3',
            'category_level4',
        ] as $category) {
            if (! empty($row[$category])) {
                $values[] = @$row[$category];
            }
        }

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['color']));

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
        $value = @$row['material'];
        if (empty($value)) {
            $value = @$row['style'];
        }

        return $this->__guess_materials($value);
    }

    protected function guess_models($row)
    {
        $value = @$row['id'];

        return $this->__guess_string($value);
    }
}

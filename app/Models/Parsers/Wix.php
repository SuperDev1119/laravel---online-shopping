<?php

namespace App\Models\Parsers;

class Wix extends \App\Models\Source
{
    public static $parser = 'wix';

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
            $value = @$row['sale_price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['price'];
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
        $value = @$row[''];

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        $values[] = @$row['google_product_category'];

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        return $this->__guess_materials(@$row['']);
    }
}

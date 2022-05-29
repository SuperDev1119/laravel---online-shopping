<?php

namespace App\Models\Parsers;

class Woocommerce extends \App\Models\Source
{
    public static $parser = 'woocommerce';

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
        if (empty($value)) {
            $value = @$row['short_description'];
        }

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
        $value = @$row['featured_image'];
        if (empty($value)) {
            $value = @$row['main_image'];
        }

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
        $values[] = @$row['parent_category'];
        $values[] = @$row['child_category'];
        $values[] = @$row['category_path'];
        $values = array_merge($values, explode(',', (string)@$row['tags']));

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

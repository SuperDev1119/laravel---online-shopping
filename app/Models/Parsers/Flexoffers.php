<?php

namespace App\Models\Parsers;

class Flexoffers extends \App\Models\Source
{
    public static $parser = 'flexoffers';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['pid']);
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
            $value = @$row['finalPrice'] ?: @$row['salePrice'] ?: @$row['price'];
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
        $value = @$row['linkUrl'];

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['manufacturer'] ?: @$row['brand'];

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
        $value = @$row['imageUrl'];

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = null;

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        $values[] = @$row['category'];

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
        return $this->__guess_materials(null);
    }

    protected function guess_currency($row)
    {
        $value = @$row['priceCurrency'];
        if (
      is_numeric($value) //in some feeds priceCurrency field contains price
      || empty($value)
    ) {
            return parent::guess_currency($row);
        }

        return $this->__guess_string($value);
    }
}

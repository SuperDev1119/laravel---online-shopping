<?php

namespace App\Models\Parsers;

class Impact extends \App\Models\Source
{
    public static $parser = 'impact';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['Unique_Merchant_SKU']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['Product_Name'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['Manufacturer'];

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['Current_Price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['Original_Price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['Product_Description'];

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = @$row['Product_URL'];

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['Manufacturer'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Gender']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['Image_URL'];

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
        $values[] = @$row['Category'];
        $values = array_merge($values, $this->handle_multiple_values(@$row['Labels']));

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['Color']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['Size']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        return $this->__guess_materials(@$row['']);
    }

    protected function product_is_not_available($row)
    {
        if (true == parent::product_is_not_available($row)) {
            return true;
        }

        if ('N' == @$row['Stock_Availability']) {
            return true;
        }

        return false;
    }
}

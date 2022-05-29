<?php

namespace App\Models\Parsers;

class NetaffiliationV3 extends \App\Models\Source
{
    public static $parser = 'netaffiliationv3';

    public $col_sep = ';';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['Id product']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['Name'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['Brand'];

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = (str_replace(',', '.', @$row['Price']));
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = (str_replace(',', '.', @$row['Crossed prices']));
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['Description'];

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = @$row['Url'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Category']);
        } // do not add me ::guess_categories(), values are too broad
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Category merchant']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Name']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['Url large image'];

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        if (empty($value)) {
            $value = @$row['Delivery delays'];
        }
        if (empty($value)) {
            $value = @$row['Availability'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        $values[] = @$row['Category merchant'];

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $value = null;

        return $this->__guess_string($value);
    }

    protected function guess_sizes($row)
    {
        $value = null;

        return $this->__guess_string($value);
    }

    protected function guess_materials($row)
    {
        $value = null;

        return $this->__guess_string($value);
    }

    protected function guess_models($row)
    {
        $value = @$row['Model'];

        return $this->__guess_string($value);
    }
}

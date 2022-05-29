<?php

namespace App\Models\Parsers;

class Rakuten extends \App\Models\Source
{
    public static $parser = 'rakuten';

    public static $headers = [
        1 => 'Product ID',
        2 => 'Product Name',
        3 => 'SKU Number',
        4 => 'Primary Category',
        5 => 'Secondary Category(ies)',
        6 => 'Product URL',
        7 => 'Product Image URL',
        8 => 'Buy URL',
        9 => 'Short description of product.',
        10 => 'Long Product',
        11 => 'Description',
        12 => 'Discount Type',
        13 => 'Sale Price',
        14 => 'Retail Price',
        15 => 'Begin Date',
        16 => 'End Date',
        17 => 'Brand',
        18 => 'Shipping',
        19 => 'Keyword(s)',
        20 => 'Manufacturer Part #',
        21 => 'Manufacturer Name',
        22 => 'Shipping Information',
        23 => 'Availability',
        24 => 'Universal Product Code',
        25 => 'Class ID',
        26 => 'Currency',
        27 => 'M1',
        28 => 'Pixel',
        29 => 'Miscellaneous',
        30 => 'Product Type',
        31 => 'Size',
        32 => 'Material',
        33 => 'Color',
        34 => 'Gender',
        35 => 'Style',
        36 => 'Age',
        37 => 'Attribute 9',
        38 => 'Attribute 10',
        39 => 'Attribute 11',
        40 => 'Attribute 12',
        41 => 'Attribute 13',
        42 => 'Attribute 14',
        43 => 'Attribute 15',
        44 => 'Attribute 16',
        45 => 'Attribute 17',
        46 => 'Attribute 18',
        47 => 'Attribute 19',
        48 => 'Attribute 20',
        49 => 'Attribute 21',
        51 => 'Modification',
    ];

    public $col_sep = '|';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['Product ID']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['Product Name'];

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
            $value = @$row['Sale Price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['Retail Price'];
        }
        if (empty($value)) {
            $value = @$row['Sale Price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['Description'];
        if (empty($value)) {
            $value = @$row['Long Product'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = @$row['Product URL'];

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['Brand'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Gender']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['Size']);
        } // Rakuten

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['Product Image URL'];

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
        $values[] = @$row['Primary Category'];
        $values[] = @$row['Secondary Category(ies)'];
        $values[] = @$row['Product Type'];

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
        return $this->__guess_materials(@$row['Material']);
    }

    protected function guess_currency($row)
    {
        $value = @$row['Currency'];

        return $this->__guess_string($value);
    }

    protected function guess_age_group($row)
    {
        return mb_strtolower(@$row['Age']);
    }
}

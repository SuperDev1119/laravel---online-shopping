<?php

namespace App\Models\Parsers;

class Partnerize extends \App\Models\Source
{
    public static $parser = 'partnerize';

    public $col_sep = '|';

    protected function guess_slug($row)
    {
        $value = @$row['id'];

        if(empty($value)) {
            $value = @$row['product_id'];
        }

        if(empty($value)) {
            $value = @$row['pid'];
        }

        return $this->__guess_slug($row, $value);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['title'];

        if(empty($value))
            $value = @$row['product_name'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['brand'];

        if(empty($value))
            $value = @$row['brand_name'];

        if (in_array($value, ['032C', '0711', '0909'])) {
            return $this->guess_merchant($row);
        }

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['sale_price_without_currency_symbol'];
        }
        if (empty($value)) {
            $value = @$row['sale_price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['price_without_currency_symbol'];
        }
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

        if (empty($value)) {
            $value = @$row['deep_link'];
        }
        if (empty($value)) {
            $value = @$row['purl'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['storename'];

        if (empty($value)) {
            $value = parent::guess_merchant($row);
        }

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['gender']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['suitable_for']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['image_link'];

        if (empty($value)) {
            $value = @$row['image_url'];
        }

        if (empty($value)) {
            $value = @$row['imgurl'];
        }

        if (false !== strpos('$value', 'https://cdn-images.farfetch-contents.com')) {
            $value = str_replace('_1000.jpg', '_500.jpg', $value);
        }

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = @$row['delivery_time'];

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        $values[] = @$row['category'];
        $values[] = @$row['product_type'];
        $values[] = @$row['google_product_category'];
        $values[] = @$row['merchant_category'];
        $values[] = @$row['product_type_old'];
        $values[] = @$row['ptype'];

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['color']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['colour']));

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
        return $this->__guess_materials(@$row['material']);
    }
}

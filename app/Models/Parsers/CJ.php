<?php

namespace App\Models\Parsers;

class CJ extends \App\Models\Source
{
    public static $parser = 'cj';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['ID']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['TITLE'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['BRAND'];

        if (in_array($merchant = $this->guess_merchant($row), ['The Kooples'])) {
            return $merchant;
        }

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['SALE_PRICE'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['PRICE'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['DESCRIPTION'];

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = @$row['LINK'];

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['PROGRAM_NAME'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['GENDER']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['IMAGE_LINK'];

        $merchant = $this->guess_merchant($row);

        if ('SHEIN' == $merchant) {
            if (false !== $pos = strpos($value, '_thumbnail_')) {
                $path_parts = pathinfo($value);
                $value = substr($value, 0, $pos).'.'.$path_parts['extension'];
            }
        } elseif (false !== stripos($merchant, 'Mytheresa')) {
            $value = str_replace('/1000/1000/95/jpeg/', '/500/500/80/jpeg/', $value);
        }

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
        $values[] = @$row['GOOGLE_PRODUCT_CATEGORY_NAME'];
        $values[] = @$row['PRODUCT_TYPE'];

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['COLOR']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];
        // $values = array_merge($values, $this->handle_multiple_values(@$row['SIZE']));
        // how to parse 'U IT  - (One size FR)' ?
        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        return $this->__guess_materials(@$row['MATERIAL']);
    }
}

<?php

namespace App\Models\Parsers;

class Daisycon extends \App\Models\Source
{
    public static $parser = 'daisycon';

    protected function before_parse_row($row)
    {
        $row = parent::before_parse_row($row);

        $row['title'] = preg_replace('/taille [0-9\.]+$/i', '', $row['title']);
        $row['title'] = preg_replace('/\(taille: [0-9\.]+\)$/i', '', $row['title']);
        $row['title'] = preg_replace('/\(maat [0-9\.]+\)$/i', '', $row['title']);
        $row['title'] = $this->__guess_string($row['title']);

        $row['description'] = preg_replace('/taille [0-9\.]+$/i', '', $row['description']);
        $row['description'] = preg_replace('/\(taille: [0-9\.]+\)$/i', '', $row['description']);
        $row['description'] = $this->__guess_string($row['description']);

        return $row;
    }

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['daisycon_unique_id']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['title'];

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['brand'];

        if (empty($value)) {
            $value = $this->guess_merchant($row);
        }

        $value = preg_replace('/ \(EU\)$/', '', $value);

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
            $value = @$row['price_old'];
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

    protected function guess_merchant($row)
    {
        $value = @$row['name'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['gender_target']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['category_path']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['image_large'];
        if (empty($value)) {
            $value = @$row['image_medium'];
        }
        if (empty($value)) {
            $value = @$row['image_small'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = @$row['delivery_time'];
        if (! empty($value)) {
            $value .= ($value > 1) ? ' days' : ' day';
        }

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        if (! empty($row['category_path'])) {
            $values[] = $row['category_path'];
        }
        if (empty($values) && ! empty($row['category'])) {
            $values[] = $row['category'];
        }

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['color_primary']));

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
        return $this->__guess_materials(@$row['material_description']);
    }

    protected function guess_models($row)
    {
        $value = @$row['model'];
        if (empty($value)) {
            $value = @$row['sku'];
        }

        return $this->__guess_string($value);
    }
}

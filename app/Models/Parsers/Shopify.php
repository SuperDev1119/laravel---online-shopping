<?php

namespace App\Models\Parsers;

class Shopify extends \App\Models\Source
{
    public static $parser = 'shopify';

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
        $value = @$row['vendor'];

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['variants'][0]['price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['variants'][0]['compare_at_price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = @$row['body_html'];

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $url = parse_url($this->path);
        $value = $url['scheme'].'://'.$url['host'].'/products/'.$row['handle'];

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = @$row['vendor'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['images'][0]['src'];

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
        $values[] = @$row['product_type'];
        $values = array_merge($values, @$row['tags']);

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        return $this->search_in_options($row, [
            'Color',
        ]);
    }

    protected function guess_sizes($row)
    {
        return $this->search_in_options($row, [
            'Size',
        ]);
    }

    protected function guess_materials($row)
    {
        return $this->search_in_options($row, [
            'Material',
        ]);
    }

    private function search_in_options($row, $matches)
    {
        foreach (@$row['options'] as $option) {
            foreach ($matches as $match) {
                if (strtolower($match) == strtolower($option['name'])) {
                    return $this->__guess_multi_string($option['values']);
                }
            }
        }
    }

    protected function product_is_not_available($row)
    {
        if (true == parent::product_is_not_available($row)) {
            return true;
        }

        if (! empty($row['variants'])) {
            $at_lease_one_is_available = false;

            foreach ($row['variants'] as $variant) {
                if (true === $variant['available']) {
                    $at_lease_one_is_available = true;
                }
            }

            if (false === $at_lease_one_is_available) {
                return true;
            }
        }

        return false;
    }
}

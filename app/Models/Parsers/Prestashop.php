<?php

namespace App\Models\Parsers;

class Prestashop extends \App\Models\Source
{
    public static $parser = 'prestashop';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['reference']);
    }

    protected function guess_product_name($row)
    {
        $value = $this->get_value_localized(@$row['name']);

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row[''];

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
            $value = @$row['regular_price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = $this->get_value_localized(@$row['description']);
        if (empty($value)) {
            $value = $this->get_value_localized(@$row['description_short']);
        }
        if (empty($value)) {
            $value = $this->get_value_localized(@$row['meta_description']);
        }

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = $this->get_base_url(true)
      .@$row['id']
      .'-'
      .@$row['id_default_combination']
      .'.html';

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
        $value = $this->get_base_url()
      .@$row['id_default_image']
      .'-'
      .$this->config[self::CONFIG_PRESTASHOP_IMAGE_TYPE]
      .'/image.jpg';

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
        $values[] = @$this->get_value_localized($this->resolve_category(@$row['id_category_default'])['name']);
        foreach (@$row['associations']['categories'] as $id) {
            $values[] = @$this->get_value_localized($this->resolve_category($id['id'])['name']);
        }

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

    private function get_base_url($include_lang = false)
    {
        $chunks = parse_url($this->path);
        $base = $chunks['scheme'].'://'.$chunks['host'].'/';

        return $base.($include_lang ? $this->config[self::CONFIG_PRESTASHOP_LANGUAGE].'/' : '');
    }

    private function get_value_localized($values)
    {
        $id_language = @$this->config[self::CONFIG_PRESTASHOP_LANGUAGE_ID];

        foreach ($values as $value) {
            if ($id_language == $value['id']) {
                return $value['value'];
            }
        }

        return false;
    }

    private function resolve_category($id_category)
    {
        static $categories = [];

        if (empty($categories)) {
            $raw_categories = json_decode(file_get_contents(
        str_replace('/products', '/categories', $this->path)
      ), true)['categories'];

            foreach ($raw_categories as $category) {
                $categories[$category['id']] = $category;
            }
        }

        return $categories[$id_category];
    }
}

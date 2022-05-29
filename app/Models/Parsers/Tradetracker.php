<?php

namespace App\Models\Parsers;

class Tradetracker extends \App\Models\Source
{
    public static $parser = 'tradetracker';

    public $col_sep = ';';

    protected function guess_slug($row)
    {
        return $this->__guess_slug($row, @$row['product ID']);
    }

    protected function guess_product_name($row)
    {
        $value = @$row['name'];
        if (strpos($value, '|') !== false) {
            $nameParts = explode('|', $value);
            $value = reset($nameParts);

            if (preg_match('#\(.*?taille.*?\)#', $value)) {
                $value = preg_replace('#(\(.*?taille.*?\))#', '', $value);
            }
        }

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = @$row['brand'];
        if (empty($value)) {
            $value = @$row['manufacturer'];
        }

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
            $value = @$row['fromPrice'];
        }
        if (empty($value)) {
            $value = str_replace(',', '.', (string)@$row['extra_Streichpreis']);
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
        $value = @$row['productURL'];

        return $this->__guess_string($value);
    }

    protected function guess_gender($row)
    {
        $value = null;
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['gender']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['extra_Zielgruppe']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = @$row['imageURL'];
        if (empty($value)) {
            $value = @$row['image_url'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = @$row['deliveryTime'];

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];

        if (! empty($row['extra_KategoriepfadName'])) {
            $values = explode('/', trim($row['extra_KategoriepfadName'], '/'));
        } else {
            foreach ([
                'categories',
                'subcategories',
                'subsubcategories',
            ] as $col) {
                if (! empty($row[$col])) {
                    $categoryParts = explode(' > ', $row[$col]);
                    $values = array_merge($values, $categoryParts);
                }
            }

            if (! empty($row['category'])) {
                $values[] = $row['category'];
            }
        }

        return $this->__guess_multi_string($values);
    }

    protected function guess_colors($row)
    {
        $values = [];

        $values = array_merge($values, $this->handle_multiple_values(@$row['color']));
        if (! empty($row['extra_MainColor'])) {
            $values[] = $row['extra_MainColor'];
        }
        if (! empty($row['extra_Farbe'])) {
            $values[] = $row['extra_Farbe'];
        }

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];

        if (empty($values)) {
            $values = @$row['size'];
        }
        if (empty($values)) {
            $values = @$row['extra_Size'];
        }
        $values = $this->handle_multiple_values($values);

        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        $value = @$row['material'];
        if (empty($value)) {
            $value = @$row['fabric'];
        }
        if (empty($value)) {
            $value = @$row['extra_Material'];
        }

        return $this->__guess_materials($value);
    }

    protected function guess_currency($row)
    {
        $value = @$row['currency'];

        return $this->__guess_string($value);
    }
}

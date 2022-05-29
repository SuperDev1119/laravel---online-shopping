<?php

namespace App\Models\Parsers;

use App\Models\Gender;

class NetaffiliationV4 extends \App\Models\Source
{
    public static $parser = 'netaffiliationv4';

    public $col_sep = '|';

    protected function before_parse_row($row)
    {
        $row = parent::before_parse_row($row);

        $row['titre'] = preg_replace('/^promo : /i', '', (string)@$row['titre']);

        if($fields = @$row['fields'])
            if(is_string($fields)) {
                try {
                    $temp = array_map(function($v) {
                        return preg_split('/(?<!g):/', $v, 2);
                    }, explode(';', $fields));

                    $row['fields'] = array_combine(
                        array_map(function($v) { return $v[0]; }, $temp),
                        array_map(function($v) { return $v[1]; }, $temp)
                    );
                } catch (\Exception $e) {
                    \Log::err("[-] NetaffiliationV4: could not parse 'fields': '$fields'");
                }
            }

        return $row;
    }

    protected function guess_slug($row)
    {
        $value = null;

        if (empty($value)) {
            $value = @$row['ean'];
        }
        if (empty($value)) {
            $value = @$row['internal reference'];
        }
        if (empty($value)) {
            $value = @$row['reference interne'];
        }
        if (empty($value)) {
            $value = @$row['référence interne'];
        }
        if (empty($value)) {
            $value = @$row['Internal reference'];
        }
        if (empty($value)) {
            $value = @$row['R_f_rence Interne'];
        }
        if (empty($value)) {
            $value = @$row['reference_interne'];
        }
        if (empty($value)) {
            $value = @$row['EAN or ISBN'];
        }
        if (empty($value)) {
            $value = @$row['gtin'];
        }
        if (empty($value)) {
            $value = @$row['EAN'];
        }
        if (empty($value)) {
            $value = @$row['id'];
        }
        if (empty($value)) {
            $value = @$row['ID'];
        }
        if (empty($value)) {
            $value = @$row['ID_PRODUCT'];
        }
        if (empty($value)) {
            $value = @$row['identifiant'];
        }
        if (empty($value)) {
            if($fields = @$row['fields'])
                if(is_array($fields))
                    $value = @$fields['ProductoID'];
        }

        return $this->__guess_slug($row, $value);
    }

    protected function guess_product_name($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['titre'];
        }
        if (empty($value)) {
            $value = @$row['name of the product'];
        }
        if (empty($value)) {
            $value = @$row['Nom'];
        }
        if (empty($value)) {
            $value = @$row['title'];
        }
        if (empty($value)) {
            $value = @$row['name'];
        }
        if (empty($value)) {
            $value = @$row['nom'];
        }
        if (empty($value)) {
            $value = @$row['Product Name'];
        }
        if (empty($value)) {
            $value = @$row['Name'];
        }
        if (empty($value)) {
            $value = @$row['NAME'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_brand_name($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['marque'];
        }
        if (empty($value)) {
            $value = @$row['brand'];
        }
        if (empty($value)) {
            $value = @$row['Nom de la marque'];
        }
        if (empty($value)) {
            $value = @$row['Brand'];
        }
        if (empty($value)) {
            $value = @$row['MARQUE'];
        }

        if ('La Boutique du Haut Talon' == $this->guess_merchant($row)) {
            $value = str_replace([
                'Chaussures femmes ',
                'Chaussures femme ',
                'Chaussures ',
                'Mode Femme ',
                'Mode ',
            ], '', $value);
        }

        return $this->__guess_string($value);
    }

    protected function guess_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['prix'];
        }
        if (empty($value)) {
            $value = @$row['current price'];
        }
        if (empty($value)) {
            $value = @$row['prix actuel'];
        }
        if (empty($value)) {
            $value = @$row['sale_price'];
        }
        if (empty($value)) {
            $value = @$row['sale-price'];
        }
        if (empty($value)) {
            $value = @$row['Current Price'];
        }
        if (empty($value)) {
            $value = @$row['Montant (TTC)'];
        }
        if (empty($value)) {
            $value = @$row['price'];
        }
        if (empty($value)) {
            $value = @$row['Current price'];
        }
        if (empty($value)) {
            $value = @$row['Price'];
        }
        if (empty($value)) {
            $value = @$row['current_price'];
        }
        if (empty($value)) {
            $value = @$row['TTC_AR'];
        }
        if (empty($value)) {
            $value = @$row['prix_actuel'];
        }
        if (empty($value)) {
            $value = @$row['prix soldé'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_old_price($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['prix_barre'];
        }
        if (empty($value)) {
            $value = @$row['crossed price'];
        }
        if (empty($value)) {
            $value = @$row['regular-price'];
        }
        if (empty($value)) {
            $value = @$row['original_price'];
        }
        if (empty($value)) {
            $value = @$row['Crossed Price'];
        }
        if (empty($value)) {
            $value = @$row['Crossed price'];
        }
        if (empty($value)) {
            $value = @$row['price_old'];
        }
        if (empty($value)) {
            $value = @$row['crossed_price'];
        }
        if (empty($value)) {
            $value = @$row['TTC_SR'];
        }
        if (empty($value)) {
            $value = @$row['old price'];
        }
        if (empty($value)) {
            $value = @$row['fromPrice'];
        }
        if (empty($value)) {
            $value = @$row['price'];
        }

        return $this->__guess_float($value);
    }

    protected function guess_description($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['description'];
        }
        if (empty($value)) {
            $value = @$row['descriptif'];
        }
        if (empty($value)) {
            $value = @$row['Discription of the product'];
        }
        if (empty($value)) {
            $value = @$row['Description'];
        }
        if (empty($value)) {
            $value = @$row['DESCRIPTION'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_url($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['URL_produit'];
        }
        if (empty($value)) {
            $value = @$row['URLproduit'];
        }
        if (empty($value)) {
            $value = @$row['product page URL'];
        }
        if (empty($value)) {
            $value = @$row['link'];
        }
        if (empty($value)) {
            $value = @$row['url'];
        }
        if (empty($value)) {
            $value = @$row['URL de la page produit'];
        }
        if (empty($value)) {
            $value = @$row['product_url'];
        }
        if (empty($value)) {
            $value = @$row['Product page URL'];
        }
        if (empty($value)) {
            $value = @$row['URL de la page'];
        }
        if (empty($value)) {
            $value = @$row['URL'];
        }
        if (empty($value)) {
            $value = @$row['product link'];
        }
        if (empty($value)) {
            $value = @$row['productURL'];
        }
        if (empty($value)) {
            $value = @$row['productUrl'];
        }
        if (empty($value)) {
            $value = @$row['product url'];
        }
        if (empty($value)) {
            $value = @$row['lien'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_merchant($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['programName'];
        }
        if (empty($value)) {
            $value = explode(' - ', $this->name)[1];
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
            $value = $this->__guess_gender_from_string(@$row['genre']);
        }
        if (empty($value)) {
            $value = $this->__guess_gender_from_string(@$row['sexe']);
        }
        if (empty($value)) {
            if($fields = @$row['fields'])
                if(is_array($fields))
                    $value = $this->__guess_gender_from_string(@$fields['g_gender']);
        }

        return $this->__guess_gender($row, $value);
    }

    protected function guess_image_url($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['big image'];
        }
        if (empty($value)) {
            $value = @$row['Big image'];
        }
        if (empty($value)) {
            $value = @$row['image_big'];
        }
        if (empty($value)) {
            $value = @$row['URL image grande'];
        }
        if (empty($value)) {
            $value = @$row['URL of the big image'];
        }
        if (empty($value)) {
            $value = @$row['URL_image_grande'];
        }

        if (empty($value)) {
            $value = @$row['URL_image'];
        }
        if (empty($value)) {
            $value = @$row['image_link'];
        }
        if (empty($value)) {
            $value = @$row['image-url'];
        }
        if (empty($value)) {
            $value = @$row['image_url'];
        }
        if (empty($value)) {
            $value = @$row['URL Image'];
        }
        if (empty($value)) {
            $value = @$row['image'];
        }
        if (empty($value)) {
            $value = @$row['IMAGE_1'];
        }
        if (empty($value)) {
            $value = @$row['image link'];
        }
        if (empty($value)) {
            $value = @$row['imageURL'];
        }
        if (empty($value)) {
            $value = @$row['imageUrl'];
        }
        if (empty($value)) {
            $value = @$row['image url'];
        }
        if (empty($value)) {
            $value = @$row['lien image'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_livraison($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['delai_de_livraison'];
        }
        if (empty($value)) {
            $value = @$row['Délai de livraison'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_models($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['model'];
        }

        return $this->__guess_string($value);
    }

    protected function guess_categories($row)
    {
        $values = [];
        $values[] = @$row['categorie'];
        $values[] = @$row['product category'];
        $values[] = @$row['product_type'];
        $values[] = @$row['google_product_category'];
        $values[] = @$row['adwords_grouping'];
        $values[] = @$row['category-breadcrumb'];
        $values[] = @$row['catégorie'];
        $values[] = @$row['categories'];
        $values[] = @$row['subcategories'];
        $values[] = @$row['subsubcategories'];
        $values[] = @$row['Product category'];
        $values[] = @$row['Cat_gorie Fil d\'ariane'];
        $values[] = @$row['Category'];
        $values[] = @$row['category'];
        $values[] = @$row['CATEGORIE'];
        $values[] = @$row['Categorie_finale'];
        $values[] = @$row['catégorie de produits Google'];

        if($fields = @$row['fields']) {
            if(is_array($fields)) {
                $values[] = @$fields['Categoria'];
            }
        }

        return $this->__guess_categories($values);
    }

    protected function guess_colors($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['couleur']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['Couleur']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['Couleurs']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['color']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['Color']));

        if($fields = @$row['fields'])
            if(is_array($fields))
                $values = array_merge($values, $this->handle_multiple_values(@$fields['g_color']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_sizes($row)
    {
        $values = [];
        $values = array_merge($values, $this->handle_multiple_values(@$row['taille']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['Taille']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['Tailles']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['size']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['Size']));

        if($fields = @$row['fields'])
            if(is_array($fields))
                $values = array_merge($values, $this->handle_multiple_values(@$fields['g_size']));

        $values = array_merge($values, $this->handle_multiple_values(@$row['SIZE']));
        $values = array_merge($values, $this->handle_multiple_values(@$row['pointure']));

        return $this->__guess_multi_string($values);
    }

    protected function guess_materials($row)
    {
        $value = null;
        if (empty($value)) {
            $value = @$row['matiere'];
        }
        if (empty($value)) {
            $value = @$row['Matière'];
        }
        if (empty($value)) {
            $value = @$row['outside-sole-material'];
        }
        if (empty($value)) {
            $value = @$row['inside-sole-material'];
        }
        if (empty($value)) {
            $value = @$row['lining-material'];
        }
        if (empty($value)) {
            $value = @$row['material'];
        }
        if (empty($value)) {
            if($fields = @$row['fields'])
                if(is_array($fields))
                    $value = @$fields['g_material'];
        }

        return $this->__guess_materials($value);
    }
}

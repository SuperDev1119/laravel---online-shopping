<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandType;
use Illuminate\Support\Facades\Request;

class BrandsController extends BaseController
{
    const SIGN_FOR_OTHERS = '#';

    private function getBrandsAll(BrandType $brand_type = null)
    {
        if ($brand_type) {
            $query = $brand_type->brands();
            $template = 'pages.shop.brands.index_all_for_type';
        } else {
            $query = Brand::query();
            $template = 'pages.shop.brands.index_all';
        }

        $brands = $query->all_listing()->get();
        $letters = [];

        foreach ($brands as $brand) {
            $letter = mb_substr($brand->display_name, 0, 1);

            if (empty($letter)) {
                continue;
            }

            $letter = ctype_alpha($letter) ? mb_strtoupper($letter) : self::SIGN_FOR_OTHERS;

            if (! isset($letters[$letter])) {
                $letters[$letter] = [$brand];
            } else {
                $letters[$letter][] = $brand;
            }
        }

        $params['brand_type'] = $brand_type;
        $params['brands_by_letter'] = $letters;
        ksort($params['brands_by_letter'], SORT_NATURAL);

        if (self::SIGN_FOR_OTHERS == array_key_first($params['brands_by_letter'])) {
            $params['brands_by_letter'] += [self::SIGN_FOR_OTHERS => array_shift($params['brands_by_letter'])];
        }

        \GoogleTagManager::set('pageType', 'brands');

        return $this->handle($template, $params, []);
    }

    public function getBrands(BrandType $brand_type = null)
    {
        $params = [];

        if (null !== Request::get('all')) {
            return $this->getBrandsAll($brand_type);
        }

        if ($brand_type) {
            $query = $brand_type->brands();
            $template = 'pages.shop.brands.index_for_type';
        } else {
            $query = Brand::doesnthave('brand_type');
            $template = 'pages.shop.brands.index';
        }

        $params['brands'] = $query->all_top()->get();
        $params['brand_type'] = $brand_type;

        \GoogleTagManager::set('pageType', 'brands');

        return $this->handle($template, $params, []);
    }
}

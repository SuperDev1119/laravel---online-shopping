<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Menu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    public function run()
    {
        $main = Menu::updateOrCreate([
            'title'     => config('app.site_name'),
        ], [
            'parent_id' => 0,
            'order'     => 0,
            'icon'      => 'fa-shopping-bag',
            'uri'       => null,
        ]);
        $main_id = $main->id;

        Menu::where('parent_id', $main_id)->delete();

        $i = 0;

        foreach ([
            'brands' => 'Brands',
            'brand-types' => 'Brand Types',
            'categories' => 'Categories',
            'colors' => 'Colors',
            'color_white_lists' => 'Color & WhiteList',
            'import_tasks' => 'Import Tasks',
            'faq-items' => 'FAQ Items',
            'footer_cmss' => 'Footer CMS',
            'google-product-categories' => 'Google Categories',
            'menu_panels' => 'Menu Panels',
            'products' => 'Products',
            'push-grids' => 'Push Grid',
            'push_linkings' => 'Push Linkings',
            'sales-periods' => 'Sales Periods',
            'sources' => 'Sources',
            'text_refs' => 'Text Refs',
            'white_lists' => 'WhiteLists',
        ] as $uri => $title) {
            Menu::updateOrCreate([
                'uri'       => $uri,
            ], [
                'parent_id' => $main_id,
                'order'     => $i++,
                'title'     => $title,
                'icon'      => 'fa-bars',
            ]);
        }
    }
}

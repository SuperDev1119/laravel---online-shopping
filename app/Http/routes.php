<?php

use App\Models\Color;
use App\Models\Gender;

if (! defined('PREFIX_COLOR')) {
    define('PREFIX_COLOR', _i('couleur'));
}

Request::macro('subdomain', function () {
    return current(explode('.', $this->getHost()));
});

Route::get('marques/sandro-paris/{query?}', function ($query = '') {
    return Redirect::to('/marques/sandro/'.$query, 301);
})->where('query', '(.*)');
Route::get('marques/{gender}/sandro-paris/{query?}', function ($gender, $query = '') {
    return Redirect::to('marques/'.$gender.'/sandro/'.$query, 301);
})->where('query', '(.*)');

Route::group([
    'laroute' => true,
    'middleware' => ['web', 'public'],
], function () {
    Route::get('/', ['uses' => 'HomeController@index'])->name('home');
    Route::get('/opensearch.xml', ['uses' => 'HomeController@opensearch'])->name('opensearch');

    if (_i('produit') != 'produit') {
        Route::get('produit/{product}', function ($product) {
            return redirect()->route('get.products.product', ['product' => $product], 301);
        });
    }

    Route::get(_i('produit').'/{product}', 'ProductsController@getProduct')->name('get.products.product');
    Route::get('redirect/{product}', 'ProductsController@getProductRedirect')->name('get.products.redirect');

    Route::get(_i('faq'), 'StaticsController@getFAQ')->name('get.static.faq');
    // Route::get('presse', 'StaticsController@getPress')->name('get.static.press');
    // Route::get('cookies', 'StaticsController@getCookies')->name('get.static.cookies');
    Route::get(_i('mentions-legales'), 'StaticsController@getLegals')->name('get.static.legals');
    // Route::get('manuel', 'StaticsController@getManual')->name('get.static.manual');
    Route::get(_i('a-propos'), 'StaticsController@getAbout')->name('get.static.about');

    Route::get('mentions_legales', function () {
        return redirect()->route('get.static.legals', null, 301);
    });
    Route::get('cgu', function () {
        return redirect()->route('get.static.legals', null, 301);
    });
});

Route::group([
    'prefix' => 'sitemap',
    'middleware' => ['web', 'public', 'disable-cache'],
], function () {
    Route::get('/', 'SitemapsController@index')->name('get.sitemap.index');
    Route::get('brands', 'SitemapsController@brands')->name('get.sitemap.brands');
    Route::get('categories', 'SitemapsController@categories')->name('get.sitemap.categories');
    Route::get('promotions', 'SitemapsController@promotions')->name('get.sitemap.promotions');
    Route::get('products', 'SitemapsController@products')->name('get.sitemap.products');
    Route::get('push_links', 'SitemapsController@push_links')->name('get.sitemap.push_links');
    Route::get('text_refs', 'SitemapsController@text_refs')->name('get.sitemap.text_refs');
    Route::get('footer_cmss', 'SitemapsController@footer_cmss')->name('get.sitemap.footer_cmss');
    Route::get('whitelists/{page?}', 'SitemapsController@whitelists')->name('get.sitemap.whitelists');
    Route::get('whitelists/colors/{page?}', 'SitemapsController@whitelists_colors')->name('get.sitemap.whitelists.colors');
});

Route::group([
    'prefix' => 'feeds',
    'middleware' => ['web', 'public'],
], function () {
    Route::feeds();
});

Route::group([
    'prefix' => 'api',
    'laroute' => true,
    'middleware' => ['web', 'api', 'public'],
], function () {
    Route::get('/categories', 'ApiController@categories')->name('api.categories');
    Route::get('/brands', 'ApiController@brands')->name('api.brands');
    Route::get('/products/{product_slug}', 'ApiController@products')->name('api.products');
});

Route::get('/search', [
    'uses' => 'ProductsController@getSearch',
    'as' => 'get.products.search',
    'middleware' => ['web', 'public'],
]);

Route::group([
    'laroute' => true,
    'prefix' => _i('mode'),
    'middleware' => ['web', 'public'],
], function () {
    Route::get('{gender}/{category}/{color_pattern}', function ($gender, $category, $color_pattern) {
        return redirect()->route('get.products.byGender.byCategory.byColor', [
            'gender' => $gender,
            'category' => $category,
            'color' => $color_pattern,
        ], 301);
    });

    Route::get('/', 'ProductsController@getProducts')
    ->name('get.products.all_products');

    Route::get('{gender}', 'ProductsController@getGrid')
    ->name('get.products.byGender');

    Route::get('{gender}/{category}', 'ProductsController@getGrid')
    ->name('get.products.byGender.byCategory');

    Route::get('{gender}/{category}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byGender.byCategory.byColor');

    Route::get('{category}', 'ProductsController@getGrid')
    ->name('get.products.byCategory');

    Route::get('/{category}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byCategory.byColor');
});

Route::get('/'._i('marques').'-{brand_type}', 'BrandsController@getBrands')
    ->name('get.brands.index_for_type')
    ->middleware(['web', 'public']);

Route::group([
    'laroute' => true,
    'prefix' => _i('marques'),
    'middleware' => ['web', 'public'],
], function () {
    Route::get('{gender}/{brand}/{color_pattern}', function ($gender, $brand, $color_pattern) {
        return redirect()->route('get.products.byGender.byBrand.byColor', [
            'gender' => $gender,
            'brand' => $brand,
            'color' => $color_pattern,
        ], 301);
    });
    Route::get('{gender}/{brand}/{category}/{color_pattern}', function ($gender, $brand, $category, $color_pattern) {
        return redirect()->route('get.products.byGender.byBrand.byCategory.byColor', [
            'gender' => $gender,
            'brand' => $brand,
            'category' => $category,
            'color' => $color_pattern,
        ], 301);
    });
    Route::get('{brand}/{color_pattern}', function ($brand, $color_pattern) {
        return redirect()->route('get.products.byBrand.byColor', [
            'brand' => $brand,
            'color' => $color_pattern,
        ], 301);
    });
    Route::get('{brand}/{category}/{color_pattern}', function ($brand, $category, $color_pattern) {
        return redirect()->route('get.products.byBrand.byCategory.byColor', [
            'brand' => $brand,
            'category' => $category,
            'color' => $color_pattern,
        ], 301);
    });

    Route::get('/', 'BrandsController@getBrands')
    ->name('get.brands.index');

    Route::get('{brand}', 'ProductsController@getGrid')
    ->name('get.products.byBrand');

    Route::get('{gender}/{brand}', 'ProductsController@getGrid')
    ->name('get.products.byGender.byBrand');

    Route::get('{gender}/{brand}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byGender.byBrand.byColor');

    Route::get('{gender}/{brand}/{category}', 'ProductsController@getGrid')
    ->name('get.products.byGender.byBrand.byCategory');

    Route::get('{gender}/{brand}/{category}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byGender.byBrand.byCategory.byColor');

    Route::get('{brand}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byBrand.byColor');

    Route::get('{brand}/{category}', 'ProductsController@getGrid')
    ->name('get.products.byBrand.byCategory');

    Route::get('{brand}/{category}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byBrand.byCategory.byColor');
});

Route::group([
    'prefix' => _i('promotions'),
    'middleware' => ['web', 'public'],
], function () {
    Route::get('/', 'ProductsController@getGrid')
    ->name('get.products.byPromotion');

    Route::get('{gender}', 'ProductsController@getGrid')
    ->name('get.products.byPromotion.byGender');

    Route::get('{gender}/{category}', 'ProductsController@getGrid')
    ->name('get.products.byPromotion.byGender.byCategory');

    Route::get('{gender}/{category}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byPromotion.byGender.byCategory.byColor');

    Route::get('{category}', 'ProductsController@getGrid')
    ->name('get.products.byPromotion.byCategory');

    Route::get('/{category}/'.PREFIX_COLOR.'-{color}', 'ProductsController@getGrid')
    ->name('get.products.byPromotion.byCategory.byColor');
});

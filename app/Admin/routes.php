<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/api/brands', 'ApiController@brands');
    $router->get('/api/categories', 'ApiController@categories');
    $router->get('/api/google_product_categories', 'ApiController@google_product_categories');

    $router->resource('colors', ColorController::class);
    $router->resource('color_white_lists', ColorWhiteListController::class);
    $router->resource('footer_cmss', FooterCmsController::class);
    $router->resource('white_lists', WhiteListController::class);
    $router->resource('text_refs', TextRefController::class);
    $router->resource('sources', SourceController::class);
    $router->resource('import_tasks', ImportTaskController::class);
    $router->resource('brands', BrandController::class);
    $router->resource('products', ProductController::class);
    $router->resource('menu_panels', MenuPanelController::class);
    $router->resource('push_linkings', PushLinkingController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('push-grids', PushGridController::class);
    $router->resource('faq-items', FaqItemController::class);
    $router->resource('google-product-categories', GoogleProductCategoryController::class);
    $router->resource('sales-periods', SalesPeriodController::class);
    $router->resource('brand-types', BrandTypeController::class);
});

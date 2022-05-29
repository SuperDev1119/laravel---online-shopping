<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Source;
use App\Models\WhiteList;

use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Dashboard')
            ->description('Description...')
            ->row(Dashboard::title())
            ->row(function (Row $row) {
                /*$row->column(3,
                    new Widgets\InfoBox(
                        'Products',
                        'shopping-bag',
                        'aqua',
                        route(ADMIN_ROUTE_PREFIX.'products.index'),
                        Product::count()
                    )
                );*/
                $row->column(3,
                    new Widgets\InfoBox(
                        'Brands',
                        'shopping-cart',
                        'green',
                        route(config('admin.route.prefix').'.brands.index'),
                        Brand::where('in_listing', true)->count() . ' / ' . Brand::count()
                    )
                );
                $row->column(3,
                    new Widgets\InfoBox(
                        'WhiteList',
                        'clipboard',
                        'yellow',
                        route(config('admin.route.prefix').'.white_lists.index'),
                        WhiteList::count()
                    )
                );
                $row->column(3,
                    new Widgets\InfoBox(
                        'Source',
                        'file',
                        'red',
                        route(config('admin.route.prefix').'.sources.index'),
                        Source::where('enabled', true)->count().' / '.Source::count()
                    )
                );
            })
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
    }
}

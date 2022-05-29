<?php

namespace App\Http\Controllers;

use App;
use App\Libraries\Cloudinary;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FooterCms;
use App\Models\Gender;
use App\Models\Product;
use App\Models\PushLinking;
use App\Models\TextRef;
use App\Models\WhiteList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class SitemapsController extends \Illuminate\Routing\Controller
{
    const PRIORITY_INDEX_BRAND = 0.8;

    const PRIORITY_BRAND = 0.7;

    const PRIORITY_CATEGORY = 0.6;

    const PRIORITY_PRODUCT = 0.3;

    const PRIORITY_PUSH = 0.5;

    const PRIORITY_TEXT_REF = 0.6;

    const PRIORITY_FOOTER_CMS = 0.6;

    const PRIORITY_WHITELIST = 0.7;

    const PRIORITY_WHITELIST_COLOR = 0.7;

    const FREQUENCY_INDEX_BRAND = 'daily';

    const FREQUENCY_BRAND = 'weekly';

    const FREQUENCY_CATEGORY = 'weekly';

    const FREQUENCY_PRODUCT = 'daily';

    const FREQUENCY_PUSH = 'weekly';

    const FREQUENCY_TEXT_REF = 'weekly';

    const FREQUENCY_FOOTER_CMS = 'weekly';

    const FREQUENCY_WHITELIST = 'daily';

    const FREQUENCY_WHITELIST_COLOR = 'daily';

    const NUMBERS_PER_PAGE = 4000;

    public function index()
    {
        $now = date('Y-m-d H:i:s');
        $sitemap = App::make('sitemap');
        $sitemap->addSitemap(route('get.sitemap.brands'), $now);
        $sitemap->addSitemap(route('get.sitemap.categories'), $now);
        // $sitemap->addSitemap(route('get.sitemap.promotions'), $now);
        $sitemap->addSitemap(route('get.sitemap.push_links'), $now);
        $sitemap->addSitemap(route('get.sitemap.text_refs'), $now);
        $sitemap->addSitemap(route('get.sitemap.footer_cmss'), $now);
        $sitemap->addSitemap(route('get.sitemap.whitelists'), $now);
        $sitemap->addSitemap(route('get.sitemap.whitelists.colors'), $now);

        return $sitemap->render('sitemapindex');
    }

    public function push_links()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-push_links');

        if (! $sitemap->isCached()) {
            $push_linkings = PushLinking::all();

            foreach ($push_linkings as $push_linking) {
                $sitemap->add(
          $push_linking->link,
          null,
          self::PRIORITY_PUSH,
          self::FREQUENCY_PUSH
        );
            }
        }

        return $sitemap->render('xml');
    }

    public function text_refs()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-text_refs');

        if (! $sitemap->isCached()) {
            $text_refs = TextRef::all();

            foreach ($text_refs as $text_ref) {
                $sitemap->add(
          config('app.url').'/'.$text_ref->url,
          null,
          self::PRIORITY_TEXT_REF,
          self::FREQUENCY_TEXT_REF
        );
            }
        }

        return $sitemap->render('xml');
    }

    public function footer_cmss()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-footer_cmss');

        if (! $sitemap->isCached()) {
            $footer_cmss = FooterCms::all();

            foreach ($footer_cmss as $footer_cms) {
                $sitemap->add(
          config('app.url').'/'.$footer_cms->url,
          null,
          self::PRIORITY_FOOTER_CMS,
          self::FREQUENCY_FOOTER_CMS
        );
            }
        }

        return $sitemap->render('xml');
    }

    public function brands()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-brands');

        if (! $sitemap->isCached()) {
            $brands = Brand::all_listing()
        ->get();

            $sitemap->add(route('get.brands.index'), null, self::PRIORITY_INDEX_BRAND, self::FREQUENCY_INDEX_BRAND);

            foreach ($brands as $brand) {
                $sitemap->add(
          get_magic_route(['brand' => $brand]),
          null,
          self::PRIORITY_BRAND,
          self::FREQUENCY_BRAND
        );
            }
        }

        return $sitemap->render('xml');
    }

    private function query_for_whitelists()
    {
        return WhiteList::where('updated_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->with(['brand', 'category']);
    }

    private function query_for_whitelists_color()
    {
        return $this->query_for_whitelists()->with(['brand', 'category', 'colors'])->has('colors');
    }

    public function whitelists($page = null)
    {
        if ($page) {
            return $this->whitelists_page($page);
        }

        $now = date('Y-m-d H:i:s');
        $sitemap = App::make('sitemap');
        $sitemap->setCache('laravel.sitemap-whitelists');

        if (! $sitemap->isCached()) {
            $amount = $this->query_for_whitelists()->count();
            $nb_pages = ceil($amount / self::NUMBERS_PER_PAGE);

            for ($i = 1; $i <= $nb_pages; $i++) {
                $sitemap->addSitemap(route('get.sitemap.whitelists', ['page' => $i]), $now);
            }
        }

        return $sitemap->render('sitemapindex');
    }

    private function whitelists_page($page)
    {
        $sitemap = App::make('sitemap');
        $sitemap->setCache('laravel.sitemap-whitelists.'.$page);

        if (! $sitemap->isCached()) {
            $whitelists = $this->query_for_whitelists()
        ->forPage($page, self::NUMBERS_PER_PAGE)
        ->get();

            foreach ($whitelists as $whitelist) {
                $sitemap->add(
          $whitelist->getRoute(),
          $whitelist->updated_at,
          self::PRIORITY_WHITELIST,
          self::FREQUENCY_WHITELIST
        );
            }
        }

        return $sitemap->render('xml');
    }

    public function whitelists_colors($page = null)
    {
        if ($page) {
            return $this->whitelists_colors_page($page);
        }

        $now = date('Y-m-d H:i:s');
        $sitemap = App::make('sitemap');
        $sitemap->setCache('laravel.sitemap-whitelists.colors');

        if (! $sitemap->isCached()) {
            $amount = $this->query_for_whitelists_color()->count();
            $nb_pages = ceil($amount / (self::NUMBERS_PER_PAGE / 10));

            for ($i = 1; $i < $nb_pages; $i++) {
                $sitemap->addSitemap(route('get.sitemap.whitelists.colors', ['page' => $i]), $now);
            }
        }

        return $sitemap->render('sitemapindex');
    }

    private function whitelists_colors_page($page)
    {
        $sitemap = App::make('sitemap');
        $sitemap->setCache('laravel.sitemap-whitelists.colors.'.$page);

        if (! $sitemap->isCached()) {
            $whitelists = $this->query_for_whitelists_color()
        ->forPage($page, (self::NUMBERS_PER_PAGE / 10))
        ->get();

            foreach ($whitelists as $whitelist) {
                foreach ($whitelist->colors as $color) {
                    $sitemap->add(
            $whitelist->getRoute(['color' => $color]),
            $whitelist->updated_at,
            self::PRIORITY_WHITELIST_COLOR,
            self::FREQUENCY_WHITELIST_COLOR
          );
                }
            }
        }

        return $sitemap->render('xml');
    }

    public function categories()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-categories');

        if (! $sitemap->isCached()) {
            $categories = Category::withoutRoot();

            foreach ($categories->get() as $category) {
                foreach (Gender::genders() as $gender) {
                    if (! Gender::areMatching($gender, $category->gender)) {
                        continue;
                    }

                    $params = [
                        'category' => $category->slug,
                        'gender' => $gender,
                    ];

                    $sitemap->add(
            get_magic_route($params),
            Carbon::now(),
            self::PRIORITY_CATEGORY,
            self::FREQUENCY_CATEGORY
          );
                }
            }
        }

        return $sitemap->render('xml');
    }

    public function promotions()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-promotions');

        if (! $sitemap->isCached()) {
            $categories = Category::whereIsLeaf();

            foreach ($categories->get() as $category) {
                foreach (Gender::genders() as $gender) {
                    if (! Gender::areMatching($gender, $category->gender)) {
                        continue;
                    }

                    $params = [
                        'promotion' => true,
                        'category' => $category->slug,
                        'gender' => $gender,
                    ];

                    $sitemap->add(
            get_magic_route($params),
            Carbon::now(),
            self::PRIORITY_CATEGORY,
            self::FREQUENCY_CATEGORY
          );
                }
            }
        }

        return $sitemap->render('xml');
    }

    public function products()
    {
        if ($page = Request::get('page')) {
            return $this->products_page($page);
        }

        $now = date('Y-m-d H:i:s');
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-products');

        if (! $sitemap->isCached()) {
            $products = Product::query();
            $nb_pages = ceil($products->count() / self::NUMBERS_PER_PAGE);

            for ($i = 0; $i <= $nb_pages; $i++) {
                $sitemap->addSitemap(route('get.sitemap.products', ['page' => 1]), $now);
            }
        }

        return $sitemap->render('sitemapindex');
    }

    private function products_page($page)
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap-products.'.$page);

        if (! $sitemap->isCached()) {
            $products = Product::forPage($page, self::NUMBERS_PER_PAGE);

            foreach ($products as $product) {
                $images = empty($product->image_url) ? [] : [
                    [
                        'url' => Cloudinary::get($product->image_url),
                        'title' => $product->name,
                        'caption' => $product->description,
                    ],
                ];

                $sitemap->add(
          route('get.products.product', ['slug' => $product->slug]),
          $product->updated_at,
          self::PRIORITY_PRODUCT,
          self::FREQUENCY_PRODUCT,
          $images
        );
            }
        }

        return $sitemap->render('xml');
    }
}

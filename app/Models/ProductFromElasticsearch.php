<?php

namespace App\Models;

use App\Libraries\ElasticsearchHelper;
use Log;

class ZeroProductException extends \Exception
{
}

class ProductFromElasticsearch
{
    const CACHING_TIME_ALL = 1440; // 60*24 ( 1 day )

    const MAX_PRODUCTS_BY_REQUEST = 3000;

    public static function get($slug)
    {
        Log::info("ProductFromElasticsearch::get($slug)");

        $products = self::all([
            'size' => 1,
            'query' => [
                'term' => ['slug.keyword' => $slug],
            ],
        ]);

        if ($product = @$products['response']['data'][0]) {
            return new Product($product);
        }

        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }

    public static function allFor($category, $gender)
    {
        $category = Category::where('slug', $category)->firstOrFail();

        $query_params = ElasticsearchHelper::buildQuery([
            'category' => $category,
            'gender' => $gender,
        ]);
        $query_params['size'] = 3000;

        return collect(array_map(function ($data) use ($category) {
            return (new Product($data))->toFeedItem($category);
        }, self::all($query_params)['response']['data']));
    }

    public static function all($query = [])
    {
        // Log::info("ProductFromElasticsearch::all()");

        $options = [
            'index' => 'products',
            'request_cache' => true,
            'body' => array_merge([
                'query' => [],
            ], $query),
        ];

        if (extension_loaded('newrelic')) {
            newrelic_add_custom_tracer('ProductFromElasticsearch::all');
        }

        $search_results = ElasticsearchHelper::getClient()->search($options);
        $result = ElasticsearchHelper::responseAdapter($search_results);

        if (extension_loaded('newrelic')) {
            newrelic_end_transaction();
        }

        if (0 == @$result['response']['total']['value']) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        return $result;
    }
}

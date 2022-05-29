<?php

namespace App\Libraries;

use App\Http\Controllers\ProductsController;
use App\Models\Category;
use App\Models\Gender;
use Elasticsearch\ClientBuilder;

class ElasticsearchHelper
{
    public static function getClient()
    {
        static $client = null;
        $client = $client ?? ClientBuilder::create()->setHosts(config('elasticsearch.connections.default.hosts'))->build();

        return $client;
    }

    public static function buildQuery($params, $page = 1, $facetsConfiguration = [])
    {
        $default__query_params__query = [
            'bool' => [
                'must' => [],
                'should' => [],
                'filter' => [],
            ],
        ];
        $query_params = [
            'from' => ($page - 1) * ProductsController::PRODUCTS_BY_PAGE,
            'size' => ProductsController::PRODUCTS_BY_PAGE,
            'query' => $default__query_params__query,
            'sort' => '_score',
        ];

        foreach ($facetsConfiguration as $facet => $facet_singular) {
            $query_params['aggs'][$facet] = [
                'terms' => [
                    'field' => $facet.'.keyword',
                    'size' => ProductsController::NB_FACETS_MAX,
                ],
            ];
        }
        $query_params['aggs']['price_min'] = ['min' => ['field' => 'price']];
        $query_params['aggs']['price_max'] = ['max' => ['field' => 'price']];

        $query_params['aggs']['reduction_max'] = ['max' => ['field' => 'reduction']];

        if ($category = @$params['category']) {
            unset($params['category']);
        }

        foreach ($params as $name => $value) {
            if (empty($value)) {
                continue;
            }

            $es_query = 'filter';

            if ('gender' == $name) {
                $value = Gender::GENDERS_FOR_QUERY[$value];
            }

            if ('color' == $name) {
                $name .= 's';
                $value = $value->name;
            }

            if ('brand' == $name) {
                $query = ['match_phrase' => ['brand_original' => $value->name]];
            } elseif ('promotion' == $name) {
                $query = ['range' => ['reduction' => ['gt' => '0']]];
            } elseif ('query' == $name) {
                $es_query = 'must';
                $query = ['multi_match' => [
                    'query' => $value,
                    'fields' => [
                        'name^2',
                        'brand_original',
                        'colors',
                        'description',
                        'categories',
                    ],
                    'operator' => 'or',
                    'type' => 'cross_fields',
                ]];
            } else {
                $n = is_array($value) ? 'terms' : 'term';
                $query = [$n => [$name.'.keyword' =>  $value]];
            }

            $query_params['query']['bool'][$es_query][] = $query;
        }

        if (! empty($category)) {
            static::buildQuery__apply__category($category, $query_params);
        }

        if ($query_params['query'] == $default__query_params__query) {
            $query_params['query'] = ['bool' => ['filter' => [0 => ['match_all' => (object) []]]]];
        }

        return $query_params;
    }

    private static function buildQuery__apply__category($category, &$query_params)
    {
        $query_params['query']['bool']['minimum_should_match'] = 1;

        $nodes = collect([$category])->merge($category->children);
        foreach ($nodes as $node) {
            foreach ($node->getQueryAsArray() as $value) {
                $query_params['query']['bool']['should'][]['multi_match'] = [
                    'query' => trim($value),
                    'fields' => ['name^2', 'categories'],
                    'operator' => 'and',
                ];
            }
        }
    }

    public static function responseAdapter($searchResults)
    {
        $normalizedResponse['status']['code'] = 200;

        $normalizedResponse['payload'] = $searchResults;

        $normalizedResponse['response']['data'] = array_map(function ($data) {
            return $data['_source'];
        }, $searchResults['hits']['hits']);

        $facets = [];
        $aggs = [];
        if (! empty($searchResults['aggregations'])) {
            foreach ($searchResults['aggregations'] as $key => $data) {
                if (! empty($data['buckets'])) {
                    foreach ($data['buckets'] as $values) {
                        $facets[$key][$values['key']] = $values;
                    }
                }

                if (isset($data['value'])) {
                    $aggs[$key]['value'] = $data['value'];
                }
            }
        }
        $normalizedResponse['response']['facets'] = $facets;
        $normalizedResponse['response']['aggs'] = $aggs;

        $normalizedResponse['response']['total'] = $searchResults['hits']['total'];

        return $normalizedResponse;
    }
}

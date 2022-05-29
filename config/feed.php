<?php

$file = __DIR__.'/feed.config.php';

if (! file_exists($file)) {
    return ['feeds' => []];
}

$feeds = [];
$config = include $file;

if (is_array($config)) {
    foreach ($config as $feed) {
        $url = $feed['url'];
        $title = $feed['title'];

        $description = $title;

        foreach ([
            [
                'url' => $url,
                'view' => 'feed::rss',
            ],

            [
                'url' => '/google'.$url,
                'view' => 'feed::google_merchant',
            ],
        ] as $c) {
            $feeds[$c['url']] = [
                'items' => [
                    'App\Models\ProductFromElasticsearch@allFor',
                    'category' => $feed['category'],
                    'gender' => $feed['gender'],
                ],

                'url' => $c['url'],
                'title' => $feed['title'],
                'description' => $description,
                'language' => str_replace('_', '-', env('LOCALE')),

                'view' => $c['view'],
                'format' => 'rss',
            ];
        }
    }
}

return [
    'feeds' => $feeds,
];

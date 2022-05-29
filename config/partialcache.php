<?php

return [

    // Enable or disable partialcache alltogether
    'enabled' => env('PARTIALCACHE_ENABLED', true),

    // The name of the blade directive to register
    'directive' => env('PARTIALCACHE_DIRECTIVE', 'cache'),

    // The base key that used for cache items
    'key' => 'partialcache',
];

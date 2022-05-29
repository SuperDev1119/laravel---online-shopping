<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    'release' => env('HEROKU_RELEASE_VERSION'),

    'environment' => env('HEROKU_APP_NAME'),

    'breadcrumbs' => [
        'sql_bindings' => true,
    ],

];

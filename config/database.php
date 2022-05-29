<?php

if ($v = env('DATABASE_URL')) {
    $db_url_from_heroku = parse_url($v);
    $db_url_from_heroku['db'] = substr(@$db_url_from_heroku['path'], 1);

    $db_url_from_heroku__follower = $db_url_from_heroku;

    if ($v = env(env('DATABASE_FOLLOWER_NAME', ''))) {
        $db_url_from_heroku__follower = parse_url($v);
    }
}

$redis_db_url_from_heroku = parse_url(env('REDISCLOUD_URL', ''));

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    'database_url' => env('DATABASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => @$db_url_from_heroku['scheme'],

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => @$db_url_from_heroku['host'],
            'prefix'   => 'ss_xyz_',
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => @$db_url_from_heroku['host'],
            'database'  => @$db_url_from_heroku['db'],
            'username'  => @$db_url_from_heroku['user'],
            'password'  => @$db_url_from_heroku['pass'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'ss_xyz_',
            'strict'    => false,
        ],

        'postgres' => [
            'driver'   => 'pgsql',

            'write' => ['host' => @$db_url_from_heroku['host']],
            'read' => ['host' => @$db_url_from_heroku__follower['host']],

            'database' => @$db_url_from_heroku['db'],
            'username' => @$db_url_from_heroku['user'],
            'password' => @$db_url_from_heroku['pass'],
            'charset'  => 'utf8',
            'prefix'   => 'ss_xyz_',
            'schema'   => 'public',
            'sslmode'	 => env('sslmode', 'prefer'),
            'options' => [
                \PDO::ATTR_PERSISTENT => boolval(env('DATABASE_PERSISTENT', false)),
            ],
        ],

        'sqlsrv' => [
            'driver'   => 'sqlsrv',
            'host'     => @$db_url_from_heroku['host'],
            'database' => @$db_url_from_heroku['db'],
            'username' => @$db_url_from_heroku['user'],
            'password' => @$db_url_from_heroku['pass'],
            'prefix'   => 'ss_xyz_',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'cluster' => env('REDIS_CLUSTER', 'redis'),

        'default' => [
            'url'      => env('REDISCLOUD_URL'),
            'host'     => @$redis_db_url_from_heroku['host'],
            'port'     => @$redis_db_url_from_heroku['port'],
            'username' => @$redis_db_url_from_heroku['user'],
            'password' => @$redis_db_url_from_heroku['pass'],
            'database' => 0,
        ],

    ],

];

<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'name' => env('SITE_NAME', 'Modalova'),
	'debug' => env('APP_DEBUG', false),
	'env' => env('APP_ENV', 'production'),

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => env('APP_URL', 'https://www.modalova.com'),
	'asset_url' => env('ASSET_URL', null),

	'thumbor_urls' => explode(',', env('THUMBOR_URLS', env('THUMBOR_URL', 'thumbor.modalova.com'))),

	'email' => 'hello@modalova.com',

	'site_name' => env('SITE_NAME', 'Modalova'),

	'link_to_instagram' => env('URL_INSTAGRAM', 'https://www.instagram.com/moda.lova/'),
	'link_to_facebook'  => env('URL_FACEBOOK', 'https://www.facebook.com/moda.lova.official'),
	'link_to_twitter'   => env('URL_TWITTER', 'https://twitter.com/ModaLovaOff'),
	'link_to_youtube'   => env('URL_YOUTUBE', 'https://www.youtube.com/channel/UCKu4J3cUnNc3Be01blRNB_Q'),
	'link_to_pinterest' => env('URL_PINTEREST', 'https://www.pinterest.fr/moda_lova/'),
	'link_to_wikipedia' => env('URL_WIKIPEDIA', 'https://wikitia.com/wiki/Modalova'),

	'enable_blog' => env('ENABLE_BLOG', false),

	'force_www' => env('FORCE_WWW', false),
	'heroku_app_name' => env('HEROKU_APP_NAME'),
	'enable_indexing' => env('ENABLE_INDEXING'),

	'obfuscate_link_to_pdp' => env('OBFUSCATE_LINK_TO_PDP', true),

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => env('TIMEZONE', 'UTC'),

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => env('LOCALE', 'fr_FR'),
	'currency' => env('CURRENCY', 'EUR'),
	'currency_sign' => env('CURRENCY_SIGN', '€'),

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'fr_FR',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => env('APP_KEY', 'Ohsh2ohbobaichoyohqueengeirohhai'),
	'cipher' => 'AES-256-CBC',

	/*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog", "errorlog"
	|
	*/

	'log' => env('LOG_CHANNEL', 'errorlog'),
	'log_level' => env('APP_LOG_LEVEL', 'error'),

	'editor' => env('EDITOR'),

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => [
		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Foundation\Providers\FoundationServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Pipeline\PipelineServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Lord\Laroute\LarouteServiceProvider',
		Illuminate\Translation\TranslationServiceProvider::class,
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Session\SessionServiceProvider',

		/*
		* Application Service Providers...
		*/
		App\Providers\AppServiceProvider::class,
		App\Providers\ConfigServiceProvider::class,
		App\Providers\EventServiceProvider::class,
		App\Providers\RouteServiceProvider::class,

		Laravelium\Sitemap\SitemapServiceProvider::class,
		Sentry\Laravel\ServiceProvider::class,

		// 'Fideloper\Proxy\TrustedProxyServiceProvider',

		Spatie\PartialCache\PartialCacheServiceProvider::class,
		Spatie\GoogleTagManager\GoogleTagManagerServiceProvider::class,

		Cocur\Slugify\Bridge\Laravel\SlugifyServiceProvider::class,
		AltThree\Bus\BusServiceProvider::class,
		App\Providers\HorizonServiceProvider::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [
		'Js' => Illuminate\Support\Js::class,
		'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
		'Date' => Illuminate\Support\Facades\Date::class,
		'Str' => Illuminate\Support\Str::class,
		'Arr' => Illuminate\Support\Arr::class,

		'App'       => 'Illuminate\Support\Facades\App',
		'Artisan'   => 'Illuminate\Support\Facades\Artisan',
		'Auth'      => 'Illuminate\Support\Facades\Auth',
		'Blade'     => 'Illuminate\Support\Facades\Blade',
		'Cache'     => 'Illuminate\Support\Facades\Cache',
		'Config'    => 'Illuminate\Support\Facades\Config',
		'Cookie'    => 'Illuminate\Support\Facades\Cookie',
		'Crypt'     => 'Illuminate\Support\Facades\Crypt',
		'DB'        => 'Illuminate\Support\Facades\DB',
		'Eloquent'  => 'Illuminate\Database\Eloquent\Model',
		'Event'     => 'Illuminate\Support\Facades\Event',
		'File'      => 'Illuminate\Support\Facades\File',
		'Hash'      => 'Illuminate\Support\Facades\Hash',
		'Inspiring' => 'Illuminate\Foundation\Inspiring',
		'Lang'      => 'Illuminate\Support\Facades\Lang',
		'Log'       => 'Illuminate\Support\Facades\Log',
		'Mail'      => 'Illuminate\Support\Facades\Mail',
		'Password'  => 'Illuminate\Support\Facades\Password',
		'Queue'     => 'Illuminate\Support\Facades\Queue',
		'Redirect'  => 'Illuminate\Support\Facades\Redirect',
		'Redis'     => 'Illuminate\Support\Facades\Redis',
		'Request'   => 'Illuminate\Support\Facades\Request',
		'Response'  => 'Illuminate\Support\Facades\Response',
		'Route'     => 'Illuminate\Support\Facades\Route',
		'Schema'    => 'Illuminate\Support\Facades\Schema',
		'Session'   => 'Illuminate\Support\Facades\Session',
		'Storage'   => 'Illuminate\Support\Facades\Storage',
		'URL'       => 'Illuminate\Support\Facades\URL',
		'Validator' => 'Illuminate\Support\Facades\Validator',
		'View'      => 'Illuminate\Support\Facades\View',
		'Sentry'    => Sentry\Laravel\Facade::class,
		'PartialCache' => Spatie\PartialCache\PartialCacheFacade::class,
		'GoogleTagManager' => Spatie\GoogleTagManager\GoogleTagManagerFacade::class,
		'Slugify'   => Cocur\Slugify\Bridge\Laravel\SlugifyFacade::class,
	],

];

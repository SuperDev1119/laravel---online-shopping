<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\App::environment('production')
            && ! $this->app->request->is(config('admin.route.prefix').'*')) {
            \URL::forceScheme('https');
            \URL::forceRootUrl(\Config::get('app.url'));
        }

        \Blade::setEchoFormat('nl2br(e(%s))');
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
    }
}

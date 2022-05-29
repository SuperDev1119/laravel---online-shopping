<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Reporter\Reporter;

class DisableModelCaching
{
    public function handle($request, Closure $next)
    {
        config(['laravel-model-caching.enabled' => false]);

        return $next($request);
    }
}

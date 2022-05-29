<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $locale = $request->subdomain();
        $locale = Request::get('locale');
        App::setLocale($locale);

        return $next($request);
    }
}

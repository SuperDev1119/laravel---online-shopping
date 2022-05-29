<?php

namespace App\Http\Middleware;

use Closure;

class ForceDomainName
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
        if (\App::environment('production')) {
            $host = $request->header('host');

            $old = parse_url('//' . $host, PHP_URL_HOST);
            $new = parse_url(config('app.url'), PHP_URL_HOST);

            // error_log("force domain: $old to $new (".$host.")");

            if ($new != $old) {
                $request->headers->set('host', str_replace(
                    $old,
                    $new,
                    $host
                ));

                return \Redirect::to($request->path(), 301);
            }
        }

        return $next($request);
    }
}

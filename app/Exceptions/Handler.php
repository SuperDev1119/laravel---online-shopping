<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\BrandNotFoundException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        \Illuminate\Queue\MaxAttemptsExceededException::class,
        \LogicException::class,
        \RedisException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Throwable $e)
    {
        if ($this->shouldReport($e)) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        }

        return parent::report($e);
    }

    public function render($request, \Throwable $e) {
      if($e instanceof BrandNotFoundException) {
        return redirect()->route('get.products.search', ['q' => $e->slug]);
      }
      if($e instanceof CategoryNotFoundException) {
        return redirect()->route('get.products.search', ['q' => $e->slug, 'brand' => $e->brand]);
      }
  
      return parent::render($request, $e);
    }
}

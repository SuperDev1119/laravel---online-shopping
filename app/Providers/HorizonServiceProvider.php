<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            return $user->can('horizon');
        });
    }
}

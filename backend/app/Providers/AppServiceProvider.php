<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // $this->app->bind('api.token', function ($app) {
        //     return Auth::guard('api')->user();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}

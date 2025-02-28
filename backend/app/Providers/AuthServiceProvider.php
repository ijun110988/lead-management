<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('app.token', function ($app) {
            return new class(env('API_TOKEN', 'secret')) {
                private $token;

                public function __construct($staticToken)
                {
                    $this->token = $staticToken;
                }

                public function checkToken($providedToken)
                {
                    return $providedToken === $this->token;
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Library\OAuth;

use Illuminate\Support\ServiceProvider;
use App\Library\OAuth\OAuth;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('oauth', function($app) {
            return new OAuth( $app );
        });
    }
}

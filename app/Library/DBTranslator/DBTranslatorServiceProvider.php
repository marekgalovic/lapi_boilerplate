<?php namespace App\Library\DBTranslator;

use Illuminate\Support\ServiceProvider;

class DBTranslatorServiceProvider extends ServiceProvider
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
        $this->app->singleton( 'dbtranslator', function()
        {
            return new DBTranslator;
        });
    }
}

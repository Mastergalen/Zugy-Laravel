<?php

namespace Zugy\Helpers\Maps;

use Illuminate\Support\ServiceProvider;

class MapsServiceProvider extends ServiceProvider
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
        $this->app->bind('maps', function($app) {
            return new Maps();
        });
    }
}

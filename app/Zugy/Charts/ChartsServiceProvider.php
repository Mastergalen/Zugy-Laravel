<?php

namespace Zugy\Charts;

use Illuminate\Support\ServiceProvider;

class ChartsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('charts', function()
        {
            return new Charts();
        });
    }
}
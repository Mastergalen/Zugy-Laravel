<?php

namespace Zugy\Stock;

use Illuminate\Support\ServiceProvider;

class StockServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('stock', function()
        {
            return new Stock();
        });
    }
}
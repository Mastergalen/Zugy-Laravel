<?php

namespace Zugy\DeliveryTime;

use Illuminate\Support\ServiceProvider;

class DeliveryTimeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('deliveryTime', function()
        {
            return new DeliveryTime();
        });
    }
}
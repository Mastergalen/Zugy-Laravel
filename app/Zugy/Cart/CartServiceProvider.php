<?php

namespace Zugy\Cart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['cart'] = $this->app->share(function($app)
        {
            $session = $app['session'];
            $events = $app['events'];
            return new Cart($session, $events);
        });
    }
}
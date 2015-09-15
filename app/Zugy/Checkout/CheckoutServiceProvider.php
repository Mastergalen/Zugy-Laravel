<?php

namespace Zugy\Checkout;

use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app['checkout'] = $this->app->share(function($app)
        {
            $session = $app['session'];
            return new Checkout($session);
        });
    }
}
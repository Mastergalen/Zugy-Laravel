<?php

namespace Zugy\PaymentGateway;

use Illuminate\Support\ServiceProvider;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('paymentGateway', function()
        {
            return new PaymentGateway();
        });
    }
}
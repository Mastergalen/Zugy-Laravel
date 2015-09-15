<?php

namespace Zugy\PaymentProcessor;

use Illuminate\Support\ServiceProvider;

class PaymentProcessorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('paymentProcessor', function()
        {
            return new PaymentProcessor();
        });
    }
}
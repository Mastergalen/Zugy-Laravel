<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\AuthenticateUser;
use Braintree_Configuration;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Set stripe API key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Braintree_Configuration::environment(env('BRAINTREE_ENVIRONMENT'));
        Braintree_Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
        Braintree_Configuration::publicKey(env('BRAINTREE_PUBLIC'));
        Braintree_Configuration::privateKey(env('BRAINTREE_PRIVATE'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment('local')) {
            $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
        }

        $this->app->bind(AuthenticateUser::class, function() {
            return new AuthenticateUser();
        });
    }
}

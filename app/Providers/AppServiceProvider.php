<?php

namespace App\Providers;
use App\Services\Payment\StripeService;
use Illuminate\Support\ServiceProvider;
use App\Jobs\AuthenticateUser;

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

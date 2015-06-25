<?php

namespace App\Providers;
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
        //
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

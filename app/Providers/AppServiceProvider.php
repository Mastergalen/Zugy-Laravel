<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthenticateUser;


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

        $this->app->bind('\AlgoliaSearch\Laravel\ModelHelper', 'Zugy\AlgoliaEloquentTrait\ZugyModelHelper');

        $this->app->bind('Zugy\Repos\Order\OrderRepository', 'Zugy\Repos\Order\DbOrderRepository');
        $this->app->bind('Zugy\Repos\Category\CategoryRepository', 'Zugy\Repos\Category\DbCategoryRepository');
        $this->app->bind('Zugy\Repos\Product\ProductRepository', 'Zugy\Repos\Product\DbProductRepository');
    }
}

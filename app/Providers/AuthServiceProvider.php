<?php

namespace App\Providers;

use App\Address;
use App\Order;
use App\Policies\AuthenticationPolicy;
use App\Product;
use App\Policies\AddressPolicy;
use App\Policies\ProductPolicy;
use App\Policies\OrderPolicy;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Order::class   => OrderPolicy::class,
        Address::class => AddressPolicy::class,
        User::class => AuthenticationPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
    }
}
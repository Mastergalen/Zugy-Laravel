<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OrderWasPlaced' => [
            'App\Listeners\SendOrderConfirmationMail',
            'App\Listeners\NotifyDriversOfOrder',
        ],
        'App\Events\OrderStatusChanged' => [
            'App\Listeners\SendOrderStatusMail',
            'App\Listeners\LogOrderStatus',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ]
    ];

    protected $subscribe = [
        'App\Listeners\CartEventsListener',
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}

<?php

namespace App\Listeners;

use App\Events\OrderWasPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pushbullet\Pushbullet;

class NotifyDriversOfOrder
{
    /**
     * @var Pushbullet
     */
    private $pb;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pb = new Pushbullet(config('services.pushbullet.token'));
    }

    /**
     * Handle the event.
     *
     * @param  OrderWasPlaced  $event
     * @return void
     */
    public function handle(OrderWasPlaced $event)
    {
        $orderUrl = action('Admin\OrderController@show', $event->order->id);
        $channel = config('site.pushbullet.channels.orders');

        $this->pb->channel($channel)->pushLink(
            "A new order has been placed on Zugy",
            $orderUrl,
            ("Total: {$event->order->total} Euro")
        );
    }
}

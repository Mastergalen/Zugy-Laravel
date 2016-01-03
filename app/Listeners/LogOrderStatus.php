<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogOrderStatus
{
    /**
     * Handle the event.
     *
     * @param  OrderStatusChanged  $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        \Activity::log([
            'contentId'   => $event->order->id,
            'contentType' => 'Order',
            'action'      => 'status-change',
            'description' => $event->order->order_status,
        ]);
    }
}

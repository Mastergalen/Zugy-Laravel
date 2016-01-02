<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderStatusMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderStatusChanged $event
     * @throws \Exception
     */
    public function handle(OrderStatusChanged $event)
    {
        switch($event->order->order_status) {
            case 2: //Out for delivery
                $view = 'emails.order.status.out-for-delivery';
                $subject = "Your Zugy order [#{$event->order->id}] is out for delivery";
                break;
            case 4: //Cancelled
                $view = 'emails.order.status.cancelled';
                $subject = "Your Zugy order [#{$event->order->id}] was cancelled";
                break;
            default:
                return;
        }

        \Mail::send($view, ['order' => $event->order], function($m) use($event, $subject) {
            $m->from(config('site.email.support'), config('site.name'));
            $m->to($event->order->email)->subject($subject);
        });
    }
}

<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderStatusMail
{
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
                $subject = trans('order.email.delivery.subject', ['id' => $event->order->id]);
                break;
            case 4: //Cancelled
                $view = 'emails.order.status.cancelled';
                $subject = trans('order.email.delivery.subject', ['id' => $event->order->id]);
                break;
            default:
                return;
        }

        try {
            \Mail::send($view, ['order' => $event->order], function($m) use($event, $subject) {
                $m->from(config('site.email.support'), config('site.name'));
                $m->to($event->order->email)->subject($subject);
            });
        } catch (\Exception $e) {
            \Log::critical('Could not send order status email');
        }
    }
}

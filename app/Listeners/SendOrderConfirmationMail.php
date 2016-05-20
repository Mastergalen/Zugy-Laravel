<?php

namespace App\Listeners;

use App\Events\OrderWasPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderConfirmationMail
{

    /**
     * Handle the event.
     *
     * @param  OrderWasPlaced  $event
     * @return void
     */
    public function handle(OrderWasPlaced $event)
    {
        \Activity::log([
            'contentId'   => $event->order->id,
            'contentType' => 'Order',
            'action'      => 'create',
        ]);

        try {
            \Mail::send('emails.order-confirmation', ['order' => $event->order], function($m) use($event) {
                $m->from(config('site.email.support'), config('site.name'));
                $m->to($event->order->email)->subject(trans('order.email.confirmation.subject', ['id' => $event->order->id]));
            });
        } catch (\Exception $e) {
            \Log::critical($e);
        }
    }
}

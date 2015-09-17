<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * Order Status:
 * 0 | New order
 * 1 | Being processed
 * 2 | Out for delivery
 * 3 | Delivered
 * 4 | Cancelled
 *
 * @package App
 */

class Order extends Model
{
    protected $table = 'orders';

    protected $with = ['items'];

    protected $appends = ['total'];

    protected $dates = ['order_placed'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    public function getVatAttribute()
    {
        $totalVat = 0;

        //Calculate VAT for items
        foreach($this->items()->get() as $item) {
            $net = $item->final_price / ((100 + $item->tax) / 100);
            $totalVat += round($item->final_price - $net, 2);
        }

        //Calculate VAT for shipping
        $fee = $this->attributes['shipping_fee'];
        $shippingTax = config('site.shippingTax');

        $net = $fee / ((100 + $shippingTax) / 100);

        $vatShipping = round($fee - $net, 2);

        $totalVat += $vatShipping;

        return $totalVat;
    }

    public function getTotalAttribute()
    {
        return $this->items()->sum('final_price');
    }

    public function getGrandTotalAttribute()
    {
        return $this->getTotalAttribute() + $this->attributes['shipping_fee'];
    }
}

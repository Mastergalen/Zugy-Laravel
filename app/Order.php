<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $with = ['items', 'coupon'];

    protected $appends = ['total'];

    protected $dates = ['order_placed', 'order_completed', 'delivery_time'];

    protected $statuses = [
        0 => 'New order',
        1 => 'Being processed',
        2 => 'Out for delivery',
        3 => 'Delivered',
        4 => 'Cancelled',
    ];

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

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }

    public function activity()
    {
        return $this->hasMany('App\ActivityLog', 'content_id')->where('content_type', '=', 'Order');
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
        return $this->getTotalAttribute() + $this->attributes['shipping_fee'] - $this->attributes['coupon_deduction'];
    }

    public function scopeUnprocessed($query) {
        return $query->where('order_status', '=', 0);
    }

    public function scopeIncomplete($query) {
        return $query->whereIn('order_status', [0, 1, 2]);
    }

    public function getActivityDescriptionForEvent($eventName)
    {
        return $eventName;
    }
}

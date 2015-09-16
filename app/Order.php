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
 * 3 | Order complete
 * 4 | Cancelled
 *
 * @package App
 */

class Order extends Model
{
    protected $table = 'orders';

    protected $with = ['items'];

    protected $appends = ['total'];

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

    public function getTotalAttribute()
    {
        return $this->items()->sum('final_price');
    }
}

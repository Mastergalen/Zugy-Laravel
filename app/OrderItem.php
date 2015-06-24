<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $table = "order_items";

    public function order() {
        return $this->belongsTo('App\Order');
    }
}

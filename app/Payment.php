<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Payment Status:
 * 0 | Unpaid
 * 1 | Paid
 * 2 | Refunded
 * 3 | Payment at delivery
 */

class Payment extends Model
{
    protected $table = 'order_payments';

    protected $casts = [
        'metadata' => 'json',
    ];
}

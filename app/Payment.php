<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Payment Status:
 * 0 | Unpaid
 * 1 | Paid
 * 2 | Refunded
 * 3 | Payment on delivery
 */

class Payment extends Model
{
    protected $table = 'order_payments';

    protected $casts = [
        'metadata' => 'json',
    ];

    public function getFormatted()
    {
        $payment = [];

        if($this->attributes['method'] == 'stripe') {
            $payment['method'] = 'card';
            $payment['card']['brand'] = $this->metadata['source']['brand'];
            $payment['card']['last4'] = $this->metadata['source']['last4'];
        } else if($this->attributes['method'] == 'cash') {
            $payment['method'] = 'cash';
        } else {
            throw new \Exception('Payment method does not exist:' . $this->attributes['method']);
        }

        return $payment;
    }
}

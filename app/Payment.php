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
        switch($this->attributes['method']) {
            case 'stripe':
                return [
                    'method' => 'card',
                    'card' => [
                        'brand' => $this->metadata['source']['brand'],
                        'last4' => $this->metadata['source']['last4']
                    ],
                ];
            case 'paypal':
                return [
                    'method' => 'paypal'
                ];
            case 'cash':
                return [
                    'method' => 'cash'
                ];
            default:
                throw new \Exception('Payment method does not exist:' . $this->attributes['method']);
                break;
        }
    }
}

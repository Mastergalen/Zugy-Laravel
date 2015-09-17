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

    public function getFormatted()
    {
        $payment = [];

        if($this->attributes['method'] == 'braintree') {
            $transactionId = json_decode($this->attributes['metadata'])->id;

            $transaction = \Braintree_Transaction::find($transactionId);

            if($transaction->paymentInstrumentType == 'paypal_account') {
                $payment['method'] = 'paypal';
                $payment['email'] = $transaction->paypalDetails->payerEmail;
            } elseif($transaction->paymentInstrumentType == 'credit_card') {
                $payment['method'] = 'card';
                $payment['card']['brand'] = $transaction->creditCardDetails->cardType;
                $payment['card']['last4'] = $transaction->creditCardDetails->last4;
            }
        } else {
            throw new \Exception('Payment method does not exist');
        }

        return $payment;
    }
}

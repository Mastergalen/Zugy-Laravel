<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'users_payment_method';

    protected $casts = [
        'payload' => 'json',
    ];

    protected $fillable = ['method', 'payload'];

    public function scopeDefault($query) {
        return $query->where('isDefault', '=', 1)->first();
    }

    public function scopeBraintree($query)
    {
        return $query->where('method', 'LIKE', 'braintree')->first();
    }

    public function getFormatted()
    {
        $payment = [];

        if($this->attributes['method'] == 'braintree') {
            $braintreeId = json_decode($this->attributes['payload'])->id;

            $customer = \Braintree_Customer::find($braintreeId);

            $paymentMethods = $customer->paymentMethods;

            foreach ($paymentMethods as $p) {

                if ($p->default === true) {
                    if ($p instanceof \Braintree_PayPalAccount) {
                        $payment['method'] = 'paypal';
                        $payment['email'] = $p->email;
                    } elseif ($p instanceof \Braintree_CreditCard) {
                        $payment['method'] = 'card';
                        $payment['card']['brand'] = $p->cardType;
                        $payment['card']['last4'] = $p->last4;
                    }
                    break;
                }
            }

        } elseif($this->attributes['method'] == 'cash') {
            $payment['method'] = 'cash';
        } else {
            throw new \Exception('Payment method does not exist');
        }

        return $payment;
    }
}

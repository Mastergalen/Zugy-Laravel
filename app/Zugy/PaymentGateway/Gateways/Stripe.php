<?php

namespace Zugy\PaymentGateway\Gateways;

use App\PaymentMethod;
use App\Payment;
use Carbon\Carbon;

class Stripe extends AbstractGateway
{
    protected $methodName = 'stripe';

    /**
     * StripeService constructor.
     */
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function addOrUpdateMethod()
    {
        $paymentMethod = $this->fetchPaymentMethod();

        if($paymentMethod === null) {
            $customer = \Stripe\Customer::create([
                "source" => request('stripeToken'),
                "description" => auth()->user()->name,
                "email" => auth()->user()->email,
            ]);

            $paymentMethod = $this->storePaymentMethod([
                'stripeId' => $customer->id,
                'sources' => $customer->sources
            ]);
        }

        return $paymentMethod;
    }

    public function charge(PaymentMethod $paymentMethod, $amount)
    {

        $payment = new Payment();

        $result = \Stripe\Charge::create([
            'amount' => (int) ($amount * 100), //Convert 15.99 to 1599
            'currency' => 'eur',
            'customer' => $paymentMethod->payload['stripeId']
        ]);

        $payment->paid = Carbon::now();

        $payment->metadata = [
            'id' => $result->id,
            'currency' => $result->currency,
        ];

        $payment->status = 1; //Mark as paid

        $payment->amount = $result->amount;
        $payment->currency = $result->currency;
        $payment->method = $paymentMethod->method;

        return $payment;
    }

    public function getFormatted(PaymentMethod $paymentMethod)
    {
        $formatted = [
            'method' => 'card',
            'card' => [
                'brand' => $paymentMethod->payload['sources']['data'][0]['brand'],
                'last4' => $paymentMethod->payload['sources']['data'][0]['last4'],
            ]
        ];

        return $formatted;
    }
}
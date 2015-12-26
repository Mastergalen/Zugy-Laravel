<?php

namespace Zugy\PaymentGateway\Gateways;

use App\Payment;
use App\PaymentMethod;
use Carbon\Carbon;
use Stripe\Customer;

class Stripe extends AbstractGateway
{
    protected $methodName = 'stripe';

    /**
     * StripeService constructor.
     * @param $paymentMethod PaymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod = null)
    {
        parent::__construct($paymentMethod);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function addOrUpdateMethod()
    {
        $this->paymentMethod = $this->fetchPaymentMethod();

        if($this->paymentMethod === null) {
            $customer = \Stripe\Customer::create([
                "source" => request('stripeToken'),
                "description" => auth()->user()->name,
                "email" => auth()->user()->email,
            ]);

            $this->paymentMethod = $this->createPaymentMethod([
                'stripeId' => $customer->id,
                'sources' => $customer->sources
            ]);
        } else {
            $customer = \Stripe\Customer::retrieve($this->paymentMethod->payload['stripeId']);

            if(request('stripeToken') !== null) { //Add a new card
                $card = $customer->sources->create([
                    "source" => request('stripeToken')
                ]);

                if(request('defaultPayment', false) == "true") {
                    $this->setCardAsDefault($customer, $card->id);
                }

                $customer = \Stripe\Customer::retrieve($this->paymentMethod->payload['stripeId']);
            } else { //Select a different card
                $customer = $this->setCardAsDefault($customer, request('cardId'));
            }

            $this->updatePaymentMethod([
                'stripeId' => $customer->id,
                'sources' => $customer->sources
            ]);

        }

        $this->setAsDefault(request('defaultPayment', false));

        return $this->paymentMethod;
    }

    public function charge($amount)
    {
        $payment = new Payment();

        $result = \Stripe\Charge::create([
            'amount' => (int) ($amount * 100), //Convert 15.99 to 1599
            'currency' => 'eur',
            'customer' => $this->paymentMethod->payload['stripeId']
        ]);

        $payment->paid = Carbon::now();

        $payment->metadata = [
            'id' => $result->id,
            'currency' => $result->currency,
            'source' => $result->source
        ];

        $payment->status = 1; //Mark as paid

        $payment->amount = $result->amount / 100; //Convert back to decimal form
        $payment->currency = $result->currency;
        $payment->method = $this->paymentMethod->method;

        return $payment;
    }

    public function getFormatted()
    {
        //First card in sources array is always default card
        $formatted = [
            'method' => 'card',
            'card' => [
                'brand' => $this->paymentMethod->payload['sources']['data'][0]['brand'],
                'last4' => $this->paymentMethod->payload['sources']['data'][0]['last4'],
                'expiry' => $this->paymentMethod->payload['sources']['data'][0]['exp_month'] . '/' . $this->paymentMethod->payload['sources']['data'][0]['exp_year']
            ]
        ];

        return $formatted;
    }

    public function listCards()
    {
        $customer = \Stripe\Customer::retrieve($this->paymentMethod->payload['stripeId']);

        $cards = [];

        foreach($customer['sources']['data'] as $card) {
            if($card['object'] == 'card') $cards[] = $card;
        }

        return $cards;
    }

    /**
     * Set the specified card as default
     * @param Customer $customer
     * @param $cardId
     * @return Customer
     */
    public function setCardAsDefault(Customer $customer, $cardId) {
        $customer->default_source = $cardId;
        return $customer->save();
    }
}
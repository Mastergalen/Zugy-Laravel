<?php
/**
 * User: Galen Han
 * Date: 10.09.2015
 * Time: 01:12
 */

namespace App\Services\Payment;

use Stripe\Customer;
use App\PaymentMethod;

class StripeService
{
    protected $methodName = 'card';

    public function addCard($token, $isDefault = false) {
        $user = auth()->user()->payment_methods()->where('method', '=', $this->methodName)->first();

        if($user === null) {
            $customer = $this->createCustomer();
        } else {
            $customer = Customer::retrieve($user->payload->stripeId);
        }

        $card = $customer->sources->create(['source' => $token]);

        //Update default card in DB
        $p = auth()->user()->payment_methods()->where('method', '=', $this->methodName)->first();

        $payload = $p->payload;
        $payload['defaultCardId'] = $card->id;

        $p->payload = $payload;
        $p->isDefault = $isDefault;
        $p->save();

        return true;
    }

    public function createCustomer() {
        $customer = Customer::create([
            'email' => auth()->user()->email,
            'metadata' => [
                'user_id' => auth()->user()->id,
                'name' => auth()->user()->name,
            ],
        ]);

        if(auth()->user()->payment_methods()->where('method', '=', $this->methodName)->count() > 0) {
            throw new \Exception('Payment method already exists.');
        }

        $p = new PaymentMethod([
            'method' => $this->methodName,
            'payload' => [
                'stripeId' => $customer->id,
            ]
        ]);

        auth()->user()->payment_methods()->save($p);

        return $customer;
    }
}
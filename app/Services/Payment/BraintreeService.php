<?php
/**
 * User: Galen Han
 * Date: 11.09.2015
 * Time: 13:37
 */

namespace App\Services\Payment;


use App\Exceptions\PaymentMethodDeclined;
use App\PaymentMethod;

class BraintreeService
{
    private $methodName = 'braintree';

    public function addMethod($paymentMethodNonce) {
        $customer = $this->createOrFetchCustomer();

        $result = \Braintree_PaymentMethod::create([
            'customerId' => $customer->id,
            'paymentMethodNonce' => $paymentMethodNonce,
        ]);

        if($result->success === false) {
            throw new PaymentMethodDeclined;
        }
    }

    public function createOrFetchCustomer() {
        if(auth()->guest()) {
            //Create new customer
            $customer = $this->createCustomer();
        } else {
            $p = auth()->user()->payment_methods()->where('method', '=', $this->methodName)->first();

            if($p === null) {
                $customer = $this->createCustomer();
            } else {
                $customerId = $p->payload['id'];

                $customer = \Braintree_Customer::find($customerId);
            }
        }

        return $customer;
    }

    public function createCustomer() {
        if(auth()->guest()) {
            $billingAddress = session('checkout.address.billing');
            $email = session('checkout.guest.email');
        } else {
            $billingAddress = auth()->user()->addresses()->billing();
            $email = auth()->user()->email;
        }

        $namePieces = explode(' ', $billingAddress->name);
        $firstName = $namePieces[0];
        array_shift($namePieces);
        $lastName = implode(' ', $namePieces);

        $result = \Braintree_Customer::create([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
        ]);

        if(auth()->check()) {
            $dbObj = new PaymentMethod();
            $dbObj->method = $this->methodName;
            $dbObj->payload = ['id' => $result->customer->id];
            $dbObj->isDefault = request('defaultPayment', false);

            auth()->user()->payment_methods()->save($dbObj);
        }

        return $result->customer;
    }
}
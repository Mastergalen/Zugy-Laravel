<?php

namespace Zugy\PaymentGateway\Gateways;

use App\Payment;
use App\PaymentMethod;

abstract class AbstractGateway
{
    /**
     * Unique identifier for this payment method e.g. 'stripe' or 'paypal'
     * @var string
     */
    protected $methodName;

    /**
     * Stores an instance of the PaymentMethod model.
     * @var PaymentMethod
     */
    protected $paymentMethod;

    /**
     * Adds or updates the payment method to the currently signed in user
     */
    abstract public function addOrUpdateMethod();

    /**
     * Fetch the PaymentMethod from DB
     * @return PaymentMethod | null
     */
    public function fetchPaymentMethod() {
        return auth()->user()->payment_methods()->where('method', '=', $this->methodName)->first();
    }

    public function storePaymentMethod($payload = null) {
        return auth()->user()->payment_methods()->create([
            'method' => $this->methodName,
            'payload' => $payload
        ]);
    }

    public function setAsDefault(PaymentMethod $paymentMethod, $setAsDefault = true) {

        //Make other payment methods false for that user first
        if($setAsDefault == true) {
            $userId = $paymentMethod->user_id;

            PaymentMethod::where('user_id', '=', $userId)->update(['isDefault' => false]);
        }
        $paymentMethod->isDefault = $setAsDefault;
        $paymentMethod->save();
    }

    /**
     * Charge the payment method
     * @param PaymentMethod $paymentMethod
     * @param String $amount E.g. '15.99'
     * @return Payment
     */
    abstract public function charge(PaymentMethod $paymentMethod, $amount);

    /**
     * Retrieve printable information on the payment method
     * @param PaymentMethod $paymentMethod
     * @return array
     */
    abstract public function getFormatted(PaymentMethod $paymentMethod);
}
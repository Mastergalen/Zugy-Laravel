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
     * AbstractGateway constructor.
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod = null)
    {
        $this->paymentMethod = $paymentMethod;
    }


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

    /**
     * Store payment method in DB
     * @param array|null $payload
     * @return PaymentMethod
     */
    public function createPaymentMethod(array $payload = null) {
        return auth()->user()->payment_methods()->create([
            'method' => $this->methodName,
            'payload' => $payload
        ]);
    }


    /**
     * Update payment method in DB
     * @param array|null $payload
     * @return PaymentMethod
     */
    public function updatePaymentMethod(array $payload = null) {
        $this->paymentMethod->payload = $payload;
        $this->paymentMethod->save();

        return $this->paymentMethod;
    }

    /**
     * Sets the current method to default in DB
     * @param bool $setAsDefault
     */
    public function setAsDefault($setAsDefault = true) {

        //Make other payment methods false for that user first
        if($setAsDefault == true) {
            $userId = $this->paymentMethod->user_id;

            PaymentMethod::where('user_id', '=', $userId)->update(['isDefault' => false]);
        }
        $this->paymentMethod->isDefault = $setAsDefault == true;
        $this->paymentMethod->save();
    }

    /**
     * Charge the payment method
     * @param PaymentMethod $paymentMethod
     * @param String $amount E.g. '15.99'
     * @return Payment
     */
    abstract public function charge($amount);

    /**
     * Retrieve printable information on the payment method
     * @param PaymentMethod $paymentMethod
     * @return array
     */
    abstract public function getFormatted();
}
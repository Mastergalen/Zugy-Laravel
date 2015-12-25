<?php

namespace Zugy\PaymentGateway\Gateways;

use App\PaymentMethod;
use App\Payment;

class Cash extends AbstractGateway
{
    protected $methodName = 'cash';

    public function addOrUpdateMethod() {
        $paymentMethod = $this->fetchPaymentMethod();

        if($paymentMethod === null) {
            $this->storePaymentMethod();
        }

        $this->setAsDefault($paymentMethod, request('defaultPayment', false));

        return $paymentMethod;
    }

    public function charge(PaymentMethod $paymentMethod, $amount)
    {
        $payment = new Payment();

        $payment->status = 0; //Mark as unpaid

        $payment->amount = $amount;
        $payment->currency = 'EUR';
        $payment->method = $this->paymentMethod->method;

        return $payment;
    }

    public function getFormatted()
    {
        $formatted['method'] = $this->methodName;
    }
}
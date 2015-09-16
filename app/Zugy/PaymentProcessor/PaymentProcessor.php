<?php
namespace Zugy\PaymentProcessor;

use App\Order;
use App\Payment;
use App\PaymentMethod;
use Carbon\Carbon;
use Zugy\PaymentProcessor\Exceptions\PaymentFailedException;
use Zugy\PaymentProcessor\Exceptions\PaymentMethodUndefinedException;


class PaymentProcessor
{
    protected $paymentMethod;

    public function method(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function charge($amount)
    {
        if($this->paymentMethod->method === 'braintree') {
            $result = \Braintree_Transaction::sale([
                'customerId' => $this->paymentMethod->payload['id'],
                'amount' => $amount,
                'options' => [
                    'submitForSettlement' => true
                ],
            ]);

            if($result != true) {
                throw new PaymentFailedException; //TODO Handle failed payments https://developers.braintreepayments.com/javascript+php/reference/response/transaction#unsuccessful-result
            }

            $payment = new Payment;
            $payment->status = 1; //Mark as paid
            $payment->amount = $amount;
            $payment->currency = $result->transaction->currencyIsoCode;
            $payment->method = $this->paymentMethod->method;
            $payment->metadata = [
                'id' => $result->transaction->id,
                'currency' => $result->transaction->currencyIsoCode,
                'type' => $result->transaction->type,
            ];
            $payment->paid = Carbon::now();

            return $payment;
        } else {
            throw new PaymentMethodUndefinedException;
        }
    }
}
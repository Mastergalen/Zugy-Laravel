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
        $payment = new Payment;

        if($this->paymentMethod->method === 'braintree') {
            $result = \Braintree_Transaction::sale([
                'customerId' => $this->paymentMethod->payload['id'],
                'amount' => $amount,
                'options' => [
                    'submitForSettlement' => true
                ],
            ]);

            if ($result != true) {
                throw new PaymentFailedException; //TODO Handle failed payments https://developers.braintreepayments.com/javascript+php/reference/response/transaction#unsuccessful-result
            }

            ;
            $payment->status = 1; //Mark as paid
            $payment->paid = Carbon::now();

            $payment->metadata = [
                'id' => $result->transaction->id,
                'currency' => $result->transaction->currencyIsoCode,
                'type' => $result->transaction->type,
            ];

        } elseif($this->paymentMethod->method === 'cash') {
            $payment->status = 0; //Mark as unpaid
        } else {
            throw new PaymentMethodUndefinedException;
        }

        $payment->amount = $amount;
        $payment->currency = 'EUR';
        $payment->method = $this->paymentMethod->method;

        //Do not save to DB

        return $payment;
    }
}
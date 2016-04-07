<?php

namespace Zugy\PaymentGateway\Gateways;

use App\Payment;
use App\PaymentMethod;
use Omnipay\Omnipay;
use Carbon\Carbon;
use Zugy\PaymentGateway\Exceptions\PaymentFailedException;

class PayPal extends AbstractGateway
{
    protected $methodName = 'paypal';

    protected $gateway;

    /**
     * PayPal constructor.
     * @param string $methodName
     */
    public function __construct(PaymentMethod $paymentMethod = null)
    {
        parent::__construct($paymentMethod);

        $this->gateway = Omnipay::create('PayPal_Express');

        $this->gateway->initialize([
            'username'  => env('PAYPAL_USERNAME'),
            'password'  => env('PAYPAL_PASSWORD'),
            'signature' => env('PAYPAL_SIGNATURE'),
            'testMode'  => env('PAYPAL_TESTMODE') == "true",
        ]);
    }


    public function addOrUpdateMethod()
    {
        $this->paymentMethod = $this->fetchPaymentMethod();

        if($this->paymentMethod === null) {
            $this->paymentMethod = $this->createPaymentMethod();
        }

        $this->setAsDefault(request('defaultPayment') !== null);

        return $this->paymentMethod;
    }

    public function charge($amount)
    {
        $parameters = [
            'cancelUrl' => localize_url('routes.checkout.gatewayReturn'), //TODO Implement cancel URL
            'returnUrl' => localize_url('routes.checkout.gatewayReturn'),
            'description' => 'Zugy Order',
            'cardReference' => 'ZUGY',
            'amount'    => $amount,
            'currency'  => 'EUR'
        ];

        if(request()->has('token')) {
            $response = $this->gateway->completePurchase($parameters)->send();

            $data = $response->getData();

            if($data['ACK'] !== 'Success') {
                \Log::warning('Payment failed');
                throw new PaymentFailedException();
            }

            $payment = new Payment();

            $payment->paid = Carbon::now();

            $payment->metadata = [
                'id' => $data['PAYMENTINFO_0_TRANSACTIONID'],
                'currency' => $data['PAYMENTINFO_0_CURRENCYCODE'],
            ];

            $payment->status = 1; //Mark as paid

            $payment->amount = $data['PAYMENTINFO_0_AMT'];
            $payment->currency = $data['PAYMENTINFO_0_CURRENCYCODE'];
            $payment->method = $this->paymentMethod->method;

            \Log::info('Payment success');

            return $payment;
        }

        $response = $this->gateway->purchase($parameters)->send();

        return redirect($response->getRedirectUrl()); //Redirect to PayPal
    }

    public function getFormatted()
    {
        return [
            'method' => $this->methodName,
        ];
    }

}
<?php

namespace Zugy\PaymentGateway;

use App\PaymentMethod;
use Zugy\PaymentGateway\Gateways\AbstractGateway;
use Zugy\PaymentGateway\Gateways\Cash;
use Zugy\PaymentGateway\Gateways\Stripe;
use Zugy\PaymentGateway\Exceptions\PaymentMethodUndefinedException;

class PaymentGateway
{
    /**
     * Sets the payment gateway
     * @param $gateway
     * @return AbstractGateway|string
     * @throws PaymentMethodUndefinedException
     */
    public function set($gateway) {
        $paymentMethod = null;

        if($gateway instanceof PaymentMethod) {
            $paymentMethod = $gateway;
            $gateway = $paymentMethod->method;
        }

        switch($gateway) {
            case 'stripe':
                return new Stripe($paymentMethod);
                break;
            case 'cash':
                return new Cash($paymentMethod);
                break;
            default:
                throw new PaymentMethodUndefinedException("Using $gateway");
                break;
        }
    }
}
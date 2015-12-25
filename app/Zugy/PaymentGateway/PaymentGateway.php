<?php

namespace Zugy\PaymentGateway;

use Zugy\PaymentGateway\Gateways\AbstractGateway;
use Zugy\PaymentGateway\Gateways\Cash;
use Zugy\PaymentGateway\Gateways\Stripe;
use Zugy\PaymentGateway\Exceptions\PaymentMethodUndefinedException;

class PaymentGateway
{
    /**
     * Sets the payment gateway
     * @param $gateway
     * @return AbstractGateway
     * @throws PaymentMethodUndefinedException
     */
    public function set($gateway) {
        switch($gateway) {
            case 'stripe':
                return new Stripe();
                break;
            case 'cash':
                return new Cash();
                break;
            default:
                throw new PaymentMethodUndefinedException("Using $gateway");
                break;
        }
    }
}
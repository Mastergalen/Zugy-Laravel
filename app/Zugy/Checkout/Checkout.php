<?php

namespace Zugy\Checkout;

use App\Address;
use App\PaymentMethod;

class Checkout
{
    protected $sessionKey = 'checkout';

    protected $session;

    public function __construct($session) {
        $this->session  = $session;
    }

    public function setShippingAddress(Address $address) {
        $this->session->put($this->sessionKey . '.address.shipping', $address);
    }

    public function setBillingAddress(Address $address) {
        $this->session->put($this->sessionKey . '.address.billing', $address);
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod) {
        $this->session->put($this->sessionKey . '.payment', $paymentMethod);
    }

    public function getShippingAddress() {
        $content = ($this->session->has($this->sessionKey . '.address.shipping')) ? $this->session->get($this->sessionKey . '.address.shipping') : null;

        if($content === null && auth()->check()) {
            $content = auth()->user()->addresses()->where('isShippingPrimary', '=', 1)->first();
        }

        return $content;
    }

    public function getBillingAddress() {
        $content = ($this->session->has($this->sessionKey . '.address.billing')) ? $this->session->get($this->sessionKey . '.address.billing') : null;

        if($content === null && auth()->check()) {
            $content = auth()->user()->addresses()->where('isBillingPrimary', '=', 1)->first();
        }

        return $content;
    }

    public function getPaymentMethod() {
        $content = ($this->session->has($this->sessionKey . '.payment')) ? $this->session->get($this->sessionKey . '.payment') : null;

        if($content === null && auth()->check()) {
            $content = auth()->user()->payment_methods()->default()->get();

            if($content->isEmpty()) return null;
        }

        return $content;
    }

    public function forget() {
        $this->session->forget($this->sessionKey);
        \Cart::destroy();
    }
}
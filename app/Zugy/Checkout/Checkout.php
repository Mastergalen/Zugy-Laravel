<?php

namespace Zugy\Checkout;

use App\Address;
use App\Coupon;
use App\Exceptions\Coupons\CouponExpiredException;
use App\Exceptions\Coupons\CouponNotStartedException;
use App\Exceptions\Coupons\CouponOrderMinimumException;
use App\Exceptions\Coupons\CouponUsedException;
use App\PaymentMethod;
use App\User;
use Carbon\Carbon;
use Zugy\Facades\Cart;

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

    public function getShippingAddress(User $user = null) {
        if($user !== null) {
            return  $user->addresses()->where('isShippingPrimary', '=', 1)->first();
        }

        $content = ($this->session->has($this->sessionKey . '.address.shipping')) ? $this->session->get($this->sessionKey . '.address.shipping') : null;

        if($content === null && auth()->check()) {
            $content = auth()->user()->addresses()->where('isShippingPrimary', '=', 1)->first();
        }

        return $content;
    }

    public function forgetShippingAddress() {
        $this->session->forget($this->sessionKey . 'address.shipping');
    }

    public function getBillingAddress(User $user = null) {
        if($user !== null) {
            return  $user->addresses()->where('isBillingPrimary', '=', 1)->first();
        }

        $content = ($this->session->has($this->sessionKey . '.address.billing')) ? $this->session->get($this->sessionKey . '.address.billing') : null;

        if($content === null && auth()->check()) {
            $content = auth()->user()->addresses()->where('isBillingPrimary', '=', 1)->first();
        }

        return $content;
    }

    public function forgetBillingAddress() {
        $this->session->forget($this->sessionKey . 'address.billing');
    }

    public function getPaymentMethod() {
        $content = ($this->session->has($this->sessionKey . '.payment')) ? $this->session->get($this->sessionKey . '.payment') : null;

        if($content === null && auth()->check()) {
            $content = auth()->user()->payment_methods()->default()->get()->first();
        }

        return $content;
    }

    public function setCoupon(Coupon $coupon)
    {
        self::validateCoupon($coupon);

        $this->session->put($this->sessionKey . '.coupon', $coupon);
    }

    public function hasCoupon()
    {
        return $this->session->has($this->sessionKey . '.coupon');
    }

    public function validateCoupon(Coupon $coupon) {
        //Check coupon has started
        if($coupon->starts != null && Carbon::now() < $coupon->starts) {
            throw new CouponNotStartedException();
        }

        //Check coupon is still valid
        if($coupon->expires != null && Carbon::now() > $coupon->expires) {
            throw new CouponExpiredException();
        }

        //Check uses
        if($coupon->max_uses != null && $coupon->uses >= $coupon->max_uses) {
            throw new CouponUsedException();
        }

        //Check minimum order total
        if($coupon->minimumTotal != null && Cart::total() < $coupon->minimumTotal) {
            throw new CouponOrderMinimumException();
        }

        return true;
    }

    public function getCoupon()
    {
        return ($this->session->has($this->sessionKey . '.coupon')) ? $this->session->get($this->sessionKey . '.coupon') : null;
    }

    public function forgetCoupon()
    {
        $this->session->forget($this->sessionKey . '.coupon');
    }


    public function setDeliveryDate($date) {
        \Log::debug('Setting delivery date to:', [$date]);
        $this->session->put($this->sessionKey . '.delivery.date', $date);
    }

    public function setDeliveryTime($time) {
        $this->session->put($this->sessionKey . '.delivery.time', $time);
    }

    public function getDeliveryDate() {
        return $this->session->get($this->sessionKey . '.delivery.date');
    }

    public function getDeliveryTime() {
        return $this->session->get($this->sessionKey . '.delivery.time');
    }

    /**
     * Forget entire shopping cart settings
     */
    public function forget() {
        $this->session->forget($this->sessionKey);
        \Cart::destroy();
    }
}
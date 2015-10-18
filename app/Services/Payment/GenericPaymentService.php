<?php

namespace App\Services\Payment;


use App\PaymentMethod;

abstract class GenericPaymentService
{
    protected $methodName;
    protected $paymentMethod;

    abstract public function addOrUpdateMethod();

    public function updateDefault(PaymentMethod $paymentMethod, $setAsDefault) {
        $setAsDefault = filter_var($setAsDefault, FILTER_VALIDATE_BOOLEAN);

        if($setAsDefault == true) {
            $userId = $paymentMethod->user_id;

            PaymentMethod::where('user_id', '=', $userId)->update(['isDefault' => false]);
        }
        $paymentMethod->isDefault = $setAsDefault;
        $paymentMethod->save();
    }
}
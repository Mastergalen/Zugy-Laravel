<?php
/**
 * Created by PhpStorm.
 * User: Mastergalen
 * Date: 17.10.2015
 * Time: 19:08
 */

namespace App\Services\Payment;


class CashService extends GenericPaymentService
{
    protected $methodName = 'cash';

    public function addOrUpdateMethod() {
        $paymentMethod = auth()->user()->payment_methods()->where('method', '=', $this->methodName)->first();

        if($paymentMethod === null) {
            //Create new
            $paymentMethod = auth()->user()->payment_methods()->create([
                'method' => $this->methodName,
            ]);
        }

        $this->updateDefault($paymentMethod, request('defaultPayment', false));

        return $paymentMethod;
    }
}
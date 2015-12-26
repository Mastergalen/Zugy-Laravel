<?php

namespace App\Services\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Zugy\Facades\Checkout;
use Zugy\Facades\PaymentGateway;

class PaymentMethodService
{
    public function setMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required',
        ]);

        $validator->sometimes('stripeToken', 'required', function($input) {
            return ($input->method == 'stripe') && ($input->cardId === null);
        });

        $validator->sometimes('cardId', 'required', function($input) {
            return ($input->method == 'stripe') && ($input->stripeToken === null);
        });

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paymentMethod = PaymentGateway::set($request->input('method'))->addOrUpdateMethod();

        Checkout::setPaymentMethod($paymentMethod);

        return true;
    }
}
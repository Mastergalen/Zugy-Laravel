<?php
/**
 * User: Galen Han
 * Date: 09.09.2015
 * Time: 23:19
 */

namespace App\Services\Payment;


use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Customer;

class PaymentMethodService
{
    private $stripeService;

    public function __construct(StripeService $stripeService) {
        $this->stripeService = $stripeService;
    }

    public function setMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required',
        ]);

        $validator->sometimes('stripeToken', 'required', function($input) {
            return isset($input->method);
        });

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        switch($request->input('method')) {
            case 'card':
                session()->put('checkout.method', $request->input('method'));

                //TODO Multiple card selection saved to session

                if($request->has('stripeToken')) {
                    $this->stripeService->addCard($request->input('stripeToken'), $request->has('defaultPayment'));
                }

                break;
        }

        return true;
    }
}
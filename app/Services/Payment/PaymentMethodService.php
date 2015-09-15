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
    private $braintree;

    public function __construct(StripeService $stripeService, BraintreeService $braintreeService) {
        $this->stripeService = $stripeService;
        $this->braintree = $braintreeService;
    }

    public function setMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required',
        ]);

        $validator->sometimes('stripeToken', 'required', function($input) {
            return $input->method == 'card';
        });

        $validator->sometimes('payment_method_nonce', 'required', function($input) {
            return $input->method == 'braintree';
        });

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        switch($request->input('method')) {
            case 'card':
                //TODO Multiple card selection saved to session

                if($request->has('stripeToken')) {
                    $this->stripeService->addCard($request->input('stripeToken'), $request->has('defaultPayment'));
                } else {
                    throw new \Exception('Missing Stripe token');
                }

                break;
            case 'braintree':
                if($request->has('payment_method_nonce')) {
                    $this->braintree->addMethod($request->input('payment_method_nonce'));
                }
                break;

            default:
                throw new \Exception('Payment method not supported');
                break;
        }

        session()->put('checkout.method', $request->input('method'));

        return true;
    }
}
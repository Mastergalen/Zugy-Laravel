<?php
/**
 * User: Galen Han
 * Date: 09.09.2015
 * Time: 23:19
 */

namespace App\Services\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Zugy\Facades\Checkout;

class PaymentMethodService
{
    private $braintree;
    /**
     * @var CashService
     */
    private $cashService;

    public function __construct(BraintreeService $braintreeService, CashService $cashService) {
        $this->braintree = $braintreeService;
        $this->cashService = $cashService;
    }

    public function setMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required',
        ]);

        $validator->sometimes('payment_method_nonce', 'required', function($input) {
            return $input->method == 'braintree';
        });

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        switch($request->input('method')) {
            case 'braintree':
                if($request->has('payment_method_nonce')) {
                    $paymentMethod = $this->braintree->addMethod($request->input('payment_method_nonce'));
                }
                break;
            case 'cash':
                $paymentMethod = $this->cashService->addOrUpdateMethod();
                break;

            default:
                throw new \Exception('Payment method not supported');
                break;
        }

        Checkout::setPaymentMethod($paymentMethod);

        return true;
    }
}
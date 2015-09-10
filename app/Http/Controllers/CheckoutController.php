<?php

namespace App\Http\Controllers;

use App\Address;
use App\Services\Order\CalculateVAT;
use App\Services\CreateOrUpdateAddress;
use App\Services\Order\PlaceOrder;
use App\Services\Payment\PaymentMethodService;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\Order\CalculateShipping;

class CheckoutController extends Controller
{
    public function __construct() {
        $this->middleware('checkout', ['except' => ['getCheckout']]);
    }

    /**
     * /checkout
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getCheckout(Request $request)
    {
        if(Cart::count() === 0) {
            return redirect(localize_url('routes.cart'));
        }

        if($request->has('guestCheckout')) {
            return redirect(localize_url('routes.checkout.address'));
        }

        if(auth()->guest()) {
            return view('pages.checkout.before');
        }

        if(!auth()->user()->hasDefaultDeliveryAddress()) {
            return redirect(localize_url('routes.checkout.address'));
        }

        if(!auth()->user()->hasDefaultPaymentMethod()) {
            return redirect(localize_url('routes.checkout.payment'));
        }

        return redirect(localize_url('routes.checkout.review'));
    }

    /**
     * /checkout/address
     */
    public function getCheckoutAddress()
    {
        return view('pages.checkout.address');
    }

    public function postCheckoutAddress(Request $request, CreateOrUpdateAddress $handler) {
        $delivery = $handler->delivery($request->input('delivery'));

        if($delivery !== true) return $delivery;

        if(!$request->has('delivery.billing_same')) {
            $billing = $handler->billing($request->input('billing'));
            if($billing !== true) return $billing;
        }

        return redirect(localize_url('routes.checkout.payment'));
    }

    /**
     * /checkout/payment
     * @return \Illuminate\View\View
     */
    public function getCheckoutPayment()
    {
        return view('pages.checkout.payment');
    }

    public function postCheckoutPayment(Request $request, PaymentMethodService $handler)
    {
        try {
            $result = $handler->setMethod($request);
        } catch(\Stripe\Error\InvalidRequest $e) {
            return redirect()->back()->withErrors(['An internal error occurred. Please try again']);
        }  catch(\Stripe\Error\Card $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }

        if($result !== true) return $result;

        return redirect(localize_url('routes.checkout.review'));
    }


    /**
     * /checkout/review
     * @return \Illuminate\View\View
     */
    public function getCheckoutReview(CalculateVAT $vat, CalculateShipping $shipping)
    {
        if(!auth()->user()->hasDefaultDeliveryAddress()) {
            return redirect(localize_url('routes.checkout.address'));
        }

        if(!auth()->user()->hasDefaultPaymentMethod()) {
            return redirect(localize_url('routes.checkout.payment'));
        }

        $cart = Cart::content();

        //Fetch delivery address information
        if(auth()->guest()) {
            if(session()->has('checkout.guest.address')) {
                return redirect(localize_url('routes.checkout.address'));
            }
            $shippingAddress = session('checkout.guest.address');
        } else {
            if(session()->has('checkout.address_id')) {
                $shippingAddress = Address::find(session('checkout.address_id'));
            } else {
                $shippingAddress = auth()->user()->addresses()->where('isShippingPrimary', '=', 1)->first();
            }
        }

        //Fetch payment information
        $payment = [];

        if(!session()->has('checkout.method')) {
            $payment_method = auth()->user()->payment_methods()->default();
            session()->put('checkout.method', $payment_method->method);
        }

        if(session('checkout.method') == 'card') {
            $payload = auth()->user()->payment_methods()->where('method', '=', 'card')->first()->payload;

            $stripeCustomer = \Stripe\Customer::retrieve($payload['stripeId']);

            if(!session()->has('checkout.card.id')) {
                session()->put('checkout.card.id', $payload['defaultCardId']);
            }

            $payment['method'] = 'card';
            $payment['card'] = $stripeCustomer->sources->retrieve(session('checkout.card.id'));
        }

        return view('pages.checkout.review')->with([
            'cart' => $cart,
            'shipping' => $shipping->getShippingCosts($cart),
            'shippingAddress' => $shippingAddress,
            'payment' => $payment,
            'vat' => $vat->order($cart),
        ]);
    }

    public function postCheckoutReview(PlaceOrder $service)
    {
        try {
            $service->handler();
        } catch(\Stripe\Error\Card $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }
}

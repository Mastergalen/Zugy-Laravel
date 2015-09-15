<?php

namespace App\Http\Controllers;

use App\Address;
use App\Exceptions\OutOfStockException;
use App\Order;
use App\Services\CreateOrUpdateAddress;
use App\Services\Order\PlaceOrder;
use App\Services\Payment\PaymentMethodService;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Cart;
use Checkout;

class CheckoutController extends Controller
{
    public function __construct() {
        $this->middleware('checkout', ['except' => ['getCheckout', 'getCheckoutGuest', 'postCheckoutGuest']]);
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

        if(auth()->guest()) {
            session()->put('url.intended', localize_url('routes.checkout.address'));
            return view('pages.checkout.before');
        }

        if(Checkout::getShippingAddress() === null) {
            return redirect(localize_url('routes.checkout.address'));
        }

        if(Checkout::getPaymentMethod()) {
            return redirect(localize_url('routes.checkout.payment'));
        }

        return redirect(localize_url('routes.checkout.review'));
    }

    public function getCheckoutGuest()
    {
        if(auth()->check()) {
            return redirect(localize_url('routes.checkout.landing'));
        }

        return view('pages.checkout.guest');
    }

    /**
     * /checkout/address
     */
    public function getCheckoutAddress()
    {
        return view('pages.checkout.address');
    }

    public function postCheckoutAddress(Request $request, CreateOrUpdateAddress $handler) {
        //Save to address to session if guest
        $delivery = $handler->delivery($request->input('delivery'));

        if(! $delivery instanceof Address) return $delivery;

        if(!$request->has('delivery.billing_same')) {
            $billing = $handler->billing($request->input('billing'));
            if(! $billing instanceof Address) return $billing;
        }

        Checkout::setShippingAddress($delivery);
        Checkout::setBillingAddress($billing);

        return redirect(localize_url('routes.checkout.payment'));
    }

    /**
     * /checkout/payment
     * @return \Illuminate\View\View
     */
    public function getCheckoutPayment()
    {
        $brainTreeSettings = [];
        if(auth()->check()) {
            $braintree = auth()->user()->payment_methods()->braintree();
            if($braintree->count() != 0) $brainTreeSettings = ['customerId' => $braintree->payload['id']];
        }

        $braintreeToken =  \Braintree_ClientToken::generate($brainTreeSettings);


        return view('pages.checkout.payment')->with(['braintreeToken' => $braintreeToken]);
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
    public function getCheckoutReview()
    {
        //TODO Check if items in cart are in stock

        //Fetch delivery address information
        $shippingAddress = Checkout::getShippingAddress();
        $paymentMethod = Checkout::getPaymentMethod();

        if($shippingAddress === null) {
            return redirect(localize_url('routes.checkout.address'));
        }

        if($paymentMethod === null) {
            return redirect(localize_url('routes.checkout.payment'));
        }

        $cart = Cart::content();

        //Fetch payment information
        $payment = [];

        if($paymentMethod->method == 'card') {
            $payload = auth()->user()->payment_methods()->where('method', '=', 'card')->first()->payload;

            $stripeCustomer = \Stripe\Customer::retrieve($payload['stripeId']);
            $card = $stripeCustomer->sources->retrieve(session('checkout.card.id'));

            if(!session()->has('checkout.card.id')) {
                session()->put('checkout.card.id', $payload['defaultCardId']);
            }

            $payment['method'] = 'card';
            $payment['card']['brand'] = $card->brand;
            $payment['card']['last4'] = $card->last4;
            $payment['card'] = $stripeCustomer->sources->retrieve(session('checkout.card.id'));
        } elseif($paymentMethod->method == 'braintree') {
            $braintreeId = $paymentMethod->payload['id'];

            $customer = \Braintree_Customer::find($braintreeId);

            $paymentMethods = $customer->paymentMethods;

            foreach($paymentMethods as $p) {

                if($p->default === true) {
                    if($p instanceof \Braintree_PayPalAccount) {
                        $payment['method'] = 'paypal';
                        $payment['email'] = $p->email;
                    } elseif($p instanceof \Braintree_CreditCard) {
                        $payment['method'] = 'card';
                        $payment['card']['brand'] = $p->cardType;
                        $payment['card']['last4'] = $p->last4;
                    }
                    break;
                }
            }
        } else {
            throw new \Exception('Payment method does not exist');
        }

        return view('pages.checkout.review')->with([
            'cart' => $cart,
            'shippingAddress' => $shippingAddress,
            'payment' => $payment,
        ]);
    }

    public function postCheckoutReview(PlaceOrder $service)
    {
        $user = auth()->user();

        try {
            $result = $service->handler($user);
        } catch(OutOfStockException $e) {
            //TODO show which item was out of stock
            return redirect()->back()->withErrors($e->getErrorMessages());

        } /* catch(\Exception $e) {
            //FIXME Log this error and alert developer
            return redirect()->back()->withErrors(['Uh oh! An unknown error occurred while placing your order.']);
        } */

        if(!$result instanceof Order) return $result;

        dd($result);

        return view('pages.checkout.confirmation')->with(['order' => $result]);

        //TODO redirect to order confirmation after succesful order
    }

    public function getCheckoutConfirmation(Request $request) {
        if(!auth()->guest()) {
            $order = auth()->user()->orders()->with('items')->find($request->get('order'));
        } else {
            if(!session()->has('order.id')) {
                return redirect(localize_url('routes.cart'));
            } else {
                $order = Order::with('items')->find(session('order.id'));
            }
        }

        return view('pages.checkout.confirmation')->with(['order' => $order]);
    }
}

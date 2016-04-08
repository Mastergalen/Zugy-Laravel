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
use Zugy\Facades\PaymentGateway;
use Zugy\PaymentGateway\Exceptions\PaymentFailedException;

class CheckoutController extends Controller
{
    public function __construct() {
        $this->middleware('checkout', ['except' => ['getCheckout']]);
    }

    /**
     * GET /checkout
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

        if(Checkout::getPaymentMethod() === null) {
            return redirect(localize_url('routes.checkout.payment'));
        }

        return redirect(localize_url('routes.checkout.review'));
    }

    /**
     * /checkout/address
     */
    public function getCheckoutAddress()
    {
        $addresses = auth()->user()->addresses()->get();

        return view('pages.checkout.address')->with(['addresses' => $addresses]);
    }

    public function postCheckoutAddress(Request $request, CreateOrUpdateAddress $handler) {
        if($request->has('delivery.addressId')) {
            $delivery = Address::find($request->input('delivery.addressId'));

            Checkout::setShippingAddress($delivery);
            return redirect(localize_url('routes.checkout.payment'));
        } else {
            $delivery = $handler->delivery($request->input('delivery'));

            if(! $delivery instanceof Address) {
                return redirect()->back()->withErrors($delivery)->withInput();
            }

            if(!$request->has('delivery.billing_same')) {
                $billing = $handler->billing($request->input('billing'));
                if(! $billing instanceof Address) {
                    return redirect()->back()->withErrors($billing)->withInput();
                }
            } else {
                $billing = $delivery;
            }
        }

        Checkout::setShippingAddress($delivery);
        Checkout::setBillingAddress($billing);

        return redirect(localize_url('routes.checkout.payment'));
    }

    /**
     * GET /checkout/payment
     * @return \Illuminate\View\View
     */
    public function getCheckoutPayment()
    {
        $paymentMethods = auth()->user()->payment_methods()->get();

        $stripe = $paymentMethods->where('method', 'stripe')->first();

        if($stripe !== null) {
            $cards = PaymentGateway::set($stripe)->listCards($stripe);
        }

        if(Checkout::getShippingAddress() === null) {
            return redirect(localize_url('routes.checkout.address'))->with('info', trans('checkout.address.prompt'));
        }

        return view('pages.checkout.payment')->with(compact('cards'));
    }

    /**
     * POST /checkout/payment
     * @param Request $request
     * @param PaymentMethodService $handler
     * @return $this|bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function postCheckoutPayment(Request $request, PaymentMethodService $paymentHandler)
    {
        try {
            $result = $paymentHandler->setMethod($request);
        } catch(\Stripe\Error\InvalidRequest $e) {
            return redirect()->back()->withErrors([trans('errors.unknown')]);
        } catch(\Stripe\Error\Card $e) {
            $errorMsg = trans('errors.stripe.' . $e->getStripeCode());
            return redirect()->back()->withErrors([$errorMsg])->withInput();
        } catch(Exception $e) {
            return redirect()->back()->withErrors([trans('errors.unknown') . $e->getMessage()])->withInput();
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
        //Fetch delivery address information
        $shippingAddress = Checkout::getShippingAddress();
        $paymentMethod = Checkout::getPaymentMethod();

        if($shippingAddress === null) {
            return redirect(localize_url('routes.checkout.address'))->with('info', trans('checkout.address.prompt'));
        }

        if($paymentMethod === null) {
            return redirect(localize_url('routes.checkout.payment'))->with('info', trans('checkout.payment.form.title'));
        }

        $cart = Cart::content();

        //Fetch payment information
        $payment = $paymentMethod->getFormatted();

        return view('pages.checkout.review')->with([
            'cart' => $cart,
            'shippingAddress' => $shippingAddress,
            'payment' => $payment,
            'coupon' => Checkout::getCoupon()
        ]);
    }

    public function postCheckoutReview(Request $request, PlaceOrder $service)
    {
        $user = auth()->user();

        try {
            $result = $service->handler($user);
        } catch(OutOfStockException $e) {
            return redirect(localize_url('routes.checkout.review'))->withErrors($e->getErrorMessages());
        } catch(\Stripe\Error\Card $e) { //Card was rejected
            $stripeErrorMsg = trans('errors.stripe.' . $e->getStripeCode());
            return redirect(localize_url('routes.checkout.review'))->withErrors([
                $stripeErrorMsg,
                trans('checkout.payment.form.error.different', ['paymentUrl' => localize_url('routes.checkout.payment')])
            ]);
        } catch(PaymentFailedException $e) {
            return redirect(localize_url('routes.checkout.review'))
                ->withErrors([trans('checkout.payment.form.error.different', ['paymentUrl' => localize_url('routes.checkout.payment')])]);
        } catch(\Exception $e) {
            \Log::alert($e);
            return redirect()->back()->withErrors([trans('errors.unknown')]);
        }

        if(!$result instanceof Order) return $result;

        return redirect(localize_url('routes.order.show', ['id' => $result->id]))
            ->withSuccess(trans('checkout.order.success'));
    }

    /**
     * Redirect back here from payment gateway e.g. PayPal
     */
    public function getGatewayReturn(Request $request, PlaceOrder $service)
    {
        return $this->postCheckoutReview($request, $service);
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

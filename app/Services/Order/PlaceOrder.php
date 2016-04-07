<?php

namespace App\Services\Order;

use Illuminate\Support\Facades\Validator;
use Log;
use App\Events\OrderWasPlaced;
use App\Payment;
use App\Product;
use App\User;
use App\Order;
use App\OrderItem;

use Carbon\Carbon;
use Zugy\Facades\Cart;

use Zugy\Facades\Checkout;
use Zugy\Facades\PaymentGateway;

use App\Exceptions\OutOfStockException;

class PlaceOrder
{
    protected $user;
    protected $products;

    protected $deliveryAddress;
    protected $billingAddress;
    protected $paymentMethod;

    public function handler(User $user) {
        $this->user = $user;

        $this->deliveryAddress = Checkout::getShippingAddress();
        $this->billingAddress = Checkout::getBillingAddress();
        $this->paymentMethod = Checkout::getPaymentMethod();

        if($this->deliveryAddress === null || $this->billingAddress === null || $this->paymentMethod === null)
        {
            return redirect(localize_url('routes.checkout.landing'));
        }

        $this->checkStock();
        
        //Load delivery time session if it not set
        if(empty(request('delivery_date')) && empty(request('delivery_time'))) {
            request()->merge(['delivery_date' => Checkout::getDeliveryDate(), 'delivery_time' => Checkout::getDeliveryTime()]);
        }

        $validator = Validator::make(request()->all(), [
            //Create validator with empty rules
        ]);

        $validator->sometimes('delivery_date', 'required|date', function($input) {
            return $input->delivery_date !== 'asap';
        });

        $validator->sometimes('delivery_time', 'required', function($input) {
            return $input->delivery_date !== 'asap';
        });

        if($validator->fails()) {
            return redirect(localize_url('routes.checkout.review'))->withErrors($validator)->withInput();
        }

        //Validate delivery time
        if(request('delivery_date') != 'asap') {
            $delivery_time = Carbon::parse(request('delivery_date') . " " . request('delivery_time'));

            $cutoff_time = Carbon::now()->addMinutes(30);

            if($delivery_time->lt($cutoff_time)) {
                return redirect()->back()->withErrors(['delivery_date' => trans('checkout.review.delivery-time.error.late')]);
            }
        }

        //Set delivery time session variables
        Checkout::setDeliveryDate(request('delivery_date'));
        Checkout::setDeliveryTime(request('delivery_time'));

        session()->save();

        $coupon = Checkout::getCoupon();

        if($coupon != null) {
            //Validate coupon
            Checkout::validateCoupon($coupon);
        }

        $payment = $this->processPayment();

        if(!$payment instanceof Payment) return $payment; //E.g. for PayPal, return redirect to gateway processor

        $order = $this->saveOrderToDB($payment);

        //Empty checkout session settings
        Checkout::forget();

        \Event::fire(new OrderWasPlaced($order));

        return $order;
    }

    /**
     * Check if items are in stock
     */
    public function checkStock() //TODO Test if works
    {
        $productIds = [];
        $cart = [];
        foreach(Cart::content() as $item) {
            $productIds[] = $item->id;
            $cart[] = ['qty' => $item->qty];
        }

        $this->products = Product::select(['id', 'stock_quantity'])->find($productIds);

        $products = $this->products->zip($cart);

        $outOfStockProducts = [];
        foreach($products as $p) {
            if($p[0]['stock_quantity'] < $p[1]['qty']) {
                $outOfStockProducts[] = $p[0];
            }
        }

        if(count($outOfStockProducts) > 0) throw new OutOfStockException($outOfStockProducts);

        return true;
    }

    public function processPayment() {
        Log::info("Charging customer", ['total' => Cart::grandTotal()]);
        $payment = PaymentGateway::set($this->paymentMethod)->charge(Cart::grandTotal());

        return $payment;
    }

    public function saveOrderToDB(Payment $payment) {
        $order = new Order();
        $order->order_status = 0; //New order status
        $order->order_placed = Carbon::now();

        $order->email                   = $this->user->email;

        $order->delivery_name           = $this->deliveryAddress->name;
        $order->delivery_line_1         = $this->deliveryAddress->line_1;
        $order->delivery_line_2         = $this->deliveryAddress->line_2;
        $order->delivery_city           = $this->deliveryAddress->city;
        $order->delivery_postcode       = $this->deliveryAddress->postcode;
        $order->delivery_state          = $this->deliveryAddress->state;
        $order->delivery_phone          = $this->deliveryAddress->phone;
        $order->delivery_country_id     = $this->deliveryAddress->country_id;
        $order->delivery_instructions   = $this->deliveryAddress->delivery_instructions;

        $order->shipping_fee            = Cart::shipping();

        $coupon = Checkout::getCoupon();

        if($coupon != null) {
            $order->coupon_id        = $coupon->id;
            $order->coupon_deduction = Cart::couponDeduction();
        }

        $order->currency                = 'EUR';

        //Delivery time
        if(request('delivery_date') == 'asap') {
            $order->delivery_time = null;
        } else {
            $order->delivery_time = Carbon::parse(request('delivery_date') . " " . request('delivery_time'));
        }

        $order = $this->user->orders()->save($order);

        //Add payment to DB, save billing address in same table
        $payment->billing_name           = $this->billingAddress->name;
        $payment->billing_line_1         = $this->billingAddress->line_1;
        $payment->billing_line_2         = $this->billingAddress->line_2;
        $payment->billing_city           = $this->billingAddress->city;
        $payment->billing_postcode       = $this->billingAddress->postcode;
        $payment->billing_state          = $this->billingAddress->state;
        $payment->billing_phone          = $this->billingAddress->phone;
        $payment->billing_country_id     = $this->billingAddress->country_id;

        $order->payment()->save($payment);

        $items = [];
        foreach(Cart::content() as $item) {
            //Update stock quantity
            $item->product->decrement('stock_quantity', $item->qty);

            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->quantity = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->final_price = $item->subtotal;
            $orderItem->tax = $item->product->tax_class->tax_rate;

            $items[] = $orderItem;
        }

        $order->items()->saveMany($items);

        //Increment coupon uses
        if($coupon != null) {
            $coupon->increment('uses');
        }

        return $order;
    }
}
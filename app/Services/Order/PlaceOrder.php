<?php

namespace App\Services\Order;

use App\Payment;
use App\Product;
use App\User;
use App\Order;
use App\OrderItem;
use App\Address;

use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

use Zugy\Facades\Checkout;
use Zugy\Facades\PaymentProcessor;

use App\Exceptions\OutOfStockException;
use Zugy\PaymentProcessor\Exceptions\PaymentMethodUndefinedException;

class PlaceOrder
{
    protected $user;
    protected $products;

    protected $deliveryAddress;
    protected $billingAddress;
    protected $paymentMethod;

    public function handler(User $user) {
        $this->user = $user;

        $this->deliveryAddress = Checkout::getShippingAddress(); //TODO Validate that delivery address is in delivery zone
        $this->billingAddress = Checkout::getBillingAddress();
        $this->paymentMethod = Checkout::getPaymentMethod();

        if($this->deliveryAddress === null || $this->billingAddress === null || $this->paymentMethod === null)
        {
            return redirect(localize_url('routes.checkout.landing'));
        }

        $this->checkStock();

        $payment = $this->processPayment();

        $order = $this->saveOrderToDB($payment);

        //TODO Alert drivers
        //TODO Send order confirmation to user with receipt, with link to track orders, even for guests

        //Empty checkout session settings
        Checkout::forget();

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

    public function getTotal(CalculateShipping $shipping) {
        $shippingFee = $shipping->getShippingCosts(Cart::content());

        return $shippingFee + Cart::total();
    }

    public function processPayment() {
        if($this->paymentMethod->method == 'braintree') {
            $payment = PaymentProcessor::method($this->paymentMethod)->charge(Cart::grandTotal()); //FIXME make this work
        } else {
            throw new PaymentMethodUndefinedException;
        }

        return $payment;
    }

    public function saveOrderToDB(Payment $payment) {
        $order = new Order();
        $order->order_status = 0; //New order status
        $order->order_placed = Carbon::now();

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

        return $order;
    }
}
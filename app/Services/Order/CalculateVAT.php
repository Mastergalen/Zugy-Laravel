<?php

namespace App\Services\Order

/**
 * User: Galen Han
 * Date: 09.09.2015
 * Time: 13:40
 */;

use Gloudemans\Shoppingcart\CartCollection;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\Order\CalculateShipping;
use App\Product;

class CalculateVAT
{
    private $shipping;

    public function __construct(CalculateShipping $shipping) {
        $this->shipping = $shipping;
    }

    public function order(CartCollection $cart) {
        $vat = $this->shipping($cart) + $this->cart($cart);

        return [
            "before_vat" =>  $this->shipping($cart) + Cart::total() - $vat,
            "vat" => $vat,
        ];
    }

    public function cart($cart)
    {
        $totalVAT = 0;

        $productIDs = [];

        $cartProducts = [];
        foreach($cart as $row) {
            $productIDs[] = $row->id;
            $cartProducts[$row->id] = ['subtotal' => $row->subtotal];
        }

        $products = Product::with(['tax_class' => function($query) {
            $query->select('id', 'tax_rate');
        }])->select('id', 'tax_class_id')->whereIn('id', $productIDs)->get();

        foreach($products as $p) {
            $net = $cartProducts[$p->id]['subtotal'] / ((100 + $p->tax_class->tax_rate) / 100);
            $totalVAT += round($cartProducts[$p->id]['subtotal'] - $net, 2);
        }

        return $totalVAT;
    }

    public function shipping(CartCollection $cart) {
        $fee = $this->shipping->getShippingCosts($cart);
        $tax = config('site.shippingTax');

        $net = $fee / ((100 + $tax) / 100);

        $vat = round($fee - $net, 2);

        return $vat;
    }
}
<?php
/**
 * User: Galen Han
 * Date: 06.09.2015
 * Time: 02:34
 */

namespace App\Services;


use Gloudemans\Shoppingcart\CartCollection;

class CalculateShipping
{
    public $cart;

    public function __construct(CartCollection $cart) {
        $this->cart = $cart;
    }

    public function getShippingCosts() {
        if($this->cartTotal() < config('site.minimumFreeShipping')) {
            return config('site.shippingFee');
        } else {
            return 0;
        }
    }

    private function cartTotal() {
        $total = 0;

        if(empty($this->cart))
        {
            return $total;
        }

        foreach($this->cart as $row)
        {
            $total += $row->subtotal;
        }

        return $total;
    }
}
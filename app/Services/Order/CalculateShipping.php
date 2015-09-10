<?php

namespace App\Services\Order;

/**
 * User: Galen Han
 * Date: 06.09.2015
 * Time: 02:34
 */

use Gloudemans\Shoppingcart\CartCollection;

class CalculateShipping
{
    public function getShippingCosts(CartCollection $cart) {
        if($this->cartTotal($cart) < config('site.minimumFreeShipping')) {
            return config('site.shippingFee');
        } else {
            return 0;
        }
    }

    private function cartTotal($cart) {
        $total = 0;

        if(empty($cart))
        {
            return $total;
        }

        foreach($cart as $row)
        {
            $total += $row->subtotal;
        }

        return $total;
    }
}
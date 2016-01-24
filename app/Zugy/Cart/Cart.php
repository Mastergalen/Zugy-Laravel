<?php

namespace Zugy\Cart;

use Gloudemans\Shoppingcart\Cart as BaseCart;
use App\Product;
use Zugy\Facades\Checkout;

class Cart extends BaseCart
{
    /**
     * Get shipping costs
     * @return int|mixed
     */
    public function shipping() {
        if($this->total() < config('site.minimumFreeShipping')) {
            return config('site.shippingFee');
        } else {
            return 0;
        }
    }

    public function totalBeforeVat()
    {
        return $this->grandTotal() - $this->vat();
    }

    public function grandTotal() {
        $grandTotal = $this->shipping() + $this->total() - $this->couponDeduction();

        if($grandTotal < 0) {
            throw new \RuntimeException("Total cannot be negative");
        }

        return $grandTotal;
    }

    public function couponDeduction()
    {
        $coupon = Checkout::getCoupon();

        if($coupon === null) {
            return 0;
        }

        if($coupon->percentageDiscount != null) {
            return round($this->total() * ($coupon->percentageDiscount / 100), 2);
        }

        if($coupon->flatDiscount != null) {
            if($coupon->flatDiscount > $this->total()) {
                return $this->total();
            }

            return $coupon->flatDiscount;
        }

        throw new \RuntimeException("Coupon type not set");
    }

    /**
     * Calculate VAT, including shipping fees
     * @return float
     */
    public function vat() {
        return $this->vatItems() + $this->vatShipping();
    }

    /**
     * Sum up VAT for items in cart
     * @return float
     */
    public function vatItems()
    {
        $totalVAT = 0;

        $productIDs = [];
        $cartProducts = [];
        foreach($this->content() as $row) {
            $productIDs[] = $row->id;
            $cartProducts[$row->id] = ['subtotal' => $row->subtotal];
        }

        $products = Product::with(['tax_class' => function($query) {
            $query->select('id', 'tax_rate');
        }])->select('id', 'tax_class_id')->whereIn('id', $productIDs)->get();

        foreach($products as $p) {
            $net = $cartProducts[$p->id]['subtotal'] / ((100 + $p->tax_class->tax_rate) / 100);
            $vat = $cartProducts[$p->id]['subtotal'] - $net;
            $totalVAT += round($vat, 2);
        }

        $coupon = Checkout::getCoupon();

        if($coupon != null && $coupon->percentageDiscount != null) {
            $totalVAT = round($totalVAT * ($coupon->percentageDiscount / 100), 2);
        } elseif($coupon != null && $coupon->flatDiscount != null) {
            $overallPercentageVat = $totalVAT / $this->total();
            $totalVAT = round(($this->total() - $this->couponDeduction()) * $overallPercentageVat, 2);
        }

        return $totalVAT;
    }

    public function vatShipping()
    {
        $fee = $this->shipping();
        $tax = config('site.shippingTax');

        $net = $fee / ((100 + $tax) / 100);

        $vatShipping = round($fee - $net, 2);

        return $vatShipping;
    }
}
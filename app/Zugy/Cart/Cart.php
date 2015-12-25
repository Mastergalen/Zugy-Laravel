<?php

namespace Zugy\Cart;

use Gloudemans\Shoppingcart\Cart as BaseCart;
use App\Product;

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
        return $this->shipping() + $this->total();
    }

    /**
     * Calculate VAT, including shipping fees
     * @return float|int
     */
    public function vat() {
        return $this->vatItems() + $this->vatShipping();
    }

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
            $totalVAT += round($cartProducts[$p->id]['subtotal'] - $net, 2);
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
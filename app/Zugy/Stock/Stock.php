<?php

namespace Zugy\Stock;

use App\Product;

use Zugy\Facades\Cart;

use App\Exceptions\OutOfStockException;

class Stock
{
    /**
     * Check if the cart of the current user has sufficient stock
     * @return boolean
     * @throws OutOfStockException
     */
    public function checkCartStock() {
        $productIds = [];
        $cart = [];

        \Log::debug('Checking stock...');

        foreach (Cart::content() as $item) {
            $productIds[] = $item->id;
            $cart[] = ['id' => $item->id, 'qty' => $item->qty];
        }

        $productStock = Product::findMany($productIds, ['id', 'stock_quantity'])->keyBy('id');

        $outOfStockProducts = [];
        foreach(Cart::content() as $product) {
            \Log::debug('Checking stock for', ['id' => $product->id, 'in_stock' => $productStock[$product->id]['stock_quantity'], 'in_cart' => $product['qty']]);
            if($productStock[$product->id]['stock_quantity'] < $product['qty']) {
                $outOfStockProducts[] = $product;
            }
        }

        if(count($outOfStockProducts) > 0) throw new OutOfStockException($outOfStockProducts);

        \Log::debug('Sufficient stock available');

        return true;
    }
}
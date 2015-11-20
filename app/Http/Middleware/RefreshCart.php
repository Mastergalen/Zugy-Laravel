<?php

namespace App\Http\Middleware;

use App\Basket;
use Closure;
use Gloudemans\Shoppingcart\Exceptions\ShoppingcartInvalidItemException;
use Gloudemans\Shoppingcart\Exceptions\ShoppingcartInvalidPriceException;
use Gloudemans\Shoppingcart\Facades\Cart;

class RefreshCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->guest()) {
            if (Cart::count(false) == 0) $this->refreshCart();
        }

        return $next($request);
    }

    private function refreshCart() {
        foreach(auth()->user()->basket()->get() as $row) {
            try {
                Cart::associate('Product', 'App')->add($row->product_id, $row->name, $row->quantity, $row->price, $row->options);
            } catch(ShoppingcartInvalidItemException $e) {
                Basket::where('product_id', '=', $row->product_id)->where('user_id', '=', $row->user_id)->delete();
            }
        }
    }
}

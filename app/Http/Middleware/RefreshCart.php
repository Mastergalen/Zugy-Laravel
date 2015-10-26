<?php

namespace App\Http\Middleware;

use Closure;
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
            Cart::associate('Product', 'App')->add($row->product_id, $row->name, $row->quantity, $row->price, $row->options);
        }
    }
}

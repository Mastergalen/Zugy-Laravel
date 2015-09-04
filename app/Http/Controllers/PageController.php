<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class PageController extends Controller
{
    /**
     * Show the cart page.
     *
     * @return Response
     */
    public function getCart()
    {
        $cart = Cart::content();

        return view('pages.cart')->with(['cart' => $cart]);
    }
}

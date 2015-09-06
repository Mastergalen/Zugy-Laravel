<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CheckoutController extends Controller
{
    public function getCheckout() {
        if(empty(Cart::content())) {
            //TODO test if works
            return redirect(Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), 'routes.cart'));
        }

        if(auth()->guest()) {
            return view('pages.checkout.before');
        }

        return view('pages.checkout.address');
    }
}

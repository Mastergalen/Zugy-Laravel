<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Show the cart page.
     *
     * @return Response
     */
    public function getCart()
    {
        return view('pages.cart');
    }
}

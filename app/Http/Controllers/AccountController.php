<?php

namespace App\Http\Controllers;


class AccountController extends Controller
{
    public function getHome()
    {
        return view('pages.account.home');
    }

    public function getOrders()
    {
        $orders = auth()->user()->orders()->orderBy('order_placed', 'desc')->get();

        return view('pages.account.orders')->with(['orders' => $orders]);
    }

    public function getSettings()
    {
        return view('pages.account.settings');
    }
}
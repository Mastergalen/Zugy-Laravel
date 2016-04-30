<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $orders = new Order();

        $revenueYesterday = $orders->where('order_placed', '>', \Carbon::yesterday())->where('order_placed', '<', \Carbon::today())->get()->sum('grand_total');
        $revenueThisMonth = $orders->where('order_placed', '>', new \Carbon('first day of this month'))->where('order_placed', '<', \Carbon::today())->get()->sum('grand_total');

        return view('admin.pages.dash')->with([
            'orders' => $orders,
            'revenueYesterday' => $revenueYesterday,
            'revenueThisMonth' => $revenueThisMonth
        ]);
    }
}
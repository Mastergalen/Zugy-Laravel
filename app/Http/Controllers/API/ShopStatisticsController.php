<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Order;

class ShopStatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * GET api/v1/shop/statistics
     */
    public function getStatistics() {
        return [
            'status' => "success",
            "payload" => [
                'revenue' => [
                    'yesterday' => Order::uncancelled()->where('order_placed', '>', \Carbon::yesterday())->where('order_placed', '<', \Carbon::today())->get()->sum('grand_total'),
                    'thisMonth'  => Order::uncancelled()->where('order_placed', '>', new \Carbon('first day of this month'))->where('order_placed', '<', \Carbon::today())->get()->sum('grand_total')
                ],
                'orders' => [
                    'incomplete' => Order::incomplete()->count()
                ]
            ]
        ];
    }
}
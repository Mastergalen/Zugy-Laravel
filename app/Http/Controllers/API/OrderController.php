<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function update(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if(Gate::denies('adminUpdate', $order)) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'order_status' => 'integer',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        if($order->order_status == $request->input('order_status')) {
            return response()->json(['status' => 'error', 'message' => trans('order.api.error.status-same')], 422);
        }

        if($request->input('order_status') == 3) {//Set status to delivered, update payment to "paid"
            $order->payment()->update(['status' => 1, 'paid' => \Carbon::now()]);
            $order->order_completed = \Carbon::now();
        }

        $order->order_status = $request->input('order_status');

        $order->save();

        \Event::fire(new OrderStatusChanged($order));

        return ['status' => 'success', 'message' => trans('order.api.update.success')];
    }

    public function show(Request $request, $orderId) {
        $order = Order::findOrFail($orderId);

        if(Gate::denies('show', $order)) {
            abort(403);
        }

        return $order;
    }
}
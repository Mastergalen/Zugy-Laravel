<?php

namespace App\Listeners;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Request;

class CartEventsListener
{
    public function onAddCart($id, $name, $quantity, $price, $options  = null) {
        if(auth()->check() && Request::ajax()) {
            auth()->user()->basket()->create([
                'product_id' => $id,
                'quantity' => $quantity,
                'price' => $price,
                'name' => $name,
                'options' => $options
            ]);
        }
    }

    public function onUpdateCart($rowId) {
        if(auth()->check()) {
            $item = Cart::get($rowId);

            $row = auth()->user()->basket()->firstOrNew(['product_id' => $item->id]);
            $row->price = $item->price;
            $row->quantity = $item->qty;
            $row->options = $item->options;

            $row->save();
        }
    }

    public function onRemoveCart($rowId) {
        if(auth()->check()) {
            $item = Cart::get($rowId);

            auth()->user()->basket()->where('product_id', '=', $item->id)->delete();
        }
    }

    public function onDestroyCart() {
        if(auth()->check()) {
            auth()->user()->basket()->delete();
        }
    }

    public function subscribe($events) {
        $events->listen(
            'cart.added',
            'App\Listeners\CartEventsListener@onAddCart'
        );

        $events->listen(
            'cart.updated',
            'App\Listeners\CartEventsListener@onUpdateCart'
        );

        $events->listen(
            'cart.remove',
            'App\Listeners\CartEventsListener@onRemoveCart'
        );

        $events->listen(
            'cart.destroy',
            'App\Listeners\CartEventsListener@onDestroyCart'
        );
    }
}
<?php

namespace App\Listeners;

use Zugy\Facades\Cart;
use Illuminate\Support\Facades\Request;

class CartEventsListener
{
    public function onAddCart($id, $name, $quantity, $price, $options  = null) {
        if(auth()->check() && Request::ajax()) {
            $row = auth()->user()->basket()->firstOrNew(['product_id' => $id]);

            $row->fill([
                'quantity' => $quantity,
                'price' => $price,
                'name' => $name,
                'options' => $options
            ])->save();
        }
    }

    public function onUpdateCart($rowId) {
        if(auth()->check()) {
            $item = Cart::get($rowId);

            $row = auth()->user()->basket()->firstOrNew(['product_id' => $item->id]);
            $row->price = $item->price;
            $row->quantity = $item->qty;
            $row->options = $item->options;

            \Log::debug('Updating basket in DB', ['productId' => $item->id, 'quantity' => $item->qty]);

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

    /**
     * Synchronise guest cart to database when user logs in
     */
    public function onLogin()
    {
        \Log::debug('User logged in');

        $guestCart = Cart::content();

        \Log::debug('Cart content', ['cart' => $guestCart]);

        $guestProductIds = [];
        foreach($guestCart as $item) {
            $row = auth()->user()->basket()->firstOrNew(['product_id' => $item->id]);

            $row->fill([
                'quantity' => $item->qty,
                'price' => $item->price,
                'name' => $item->name,
                'options' => $item->options
            ])->save();

            $guestProductIds[] = $item->id;
        }

        $missingDbProducts = auth()->user()->basket()->whereNotIn('product_id', $guestProductIds)->get();

        foreach($missingDbProducts as $p) {
            \Log::debug('Adding missing product to cart', ['name' => $p->name]);
            Cart::associate('Product', 'App')->add($p->product_id, $p->name, $p->quantity, $p->price, $p->options);
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

        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\CartEventsListener@onLogin'
        );
    }
}
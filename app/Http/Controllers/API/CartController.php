<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * List all items in cart
     *
     * @return Response
     */
    public function index()
    {
        if(Cart::count(false) === 0 && !auth()->guest()) { //Check if cart stored in database
            foreach(auth()->user()->basket() as $row) {
                Cart::associate('Product', 'App')->add($row->product_id, $row->name, $row->quantity, $row->price, $row->options);
            }
        }

        return Cart::content();
    }

    /**
     * Add a new item to cart
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:products',
            'name' => 'required|max:255|min:1',
            'qty' => 'required|integer|min:0',
            'options' => 'array',
        ]);

        $price = Product::find($request->input('id'))->price;

        $cartItem = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'qty' => $request->input('qty'),
            'price' => $price,
        ];

        //Search for product ID, if exists, update quantity
        if($request->has('options')) {
            $searchResult = Cart::search(['id' => $request->input('id'), 'options' => $request->input('options')]);
            $cartItem['options'] = $request->input('options');
        } else {
            $searchResult = Cart::search(['id' => $request->input('id')]);
        }

        if($searchResult === false) {
            Cart::associate('Product', 'App')->add($cartItem);
        } else {
            $rowId = $searchResult[0];

            $oldQuantity = Cart::get($rowId)->qty;
            Cart::update($rowId, ['qty' => $oldQuantity + $request->input('qty')]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Update an item in the cart
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $rowId)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'qty' => 'integer|min:0',
            'options' => 'array',
        ]);

        $update = [];

        if($request->has('name')) $update['name'] =  $request->input('name');
        if($request->has('qty')) $update['qty'] = (int) $request->input('qty');
        if($request->has('options')) $update['options'] =  $request->input('options');

        Cart::update($rowId, $update);

        return response()->json(['status' => 'success', 'cart' => Cart::content()]);
    }

    /**
     * Remove an item from the cart.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return response()->json(['status' => 'success']);
    }
}

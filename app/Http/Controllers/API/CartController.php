<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Gloudemans\Shoppingcart\Exceptions\ShoppingcartInvalidRowIDException;
use Illuminate\Http\Response;
use Zugy\Facades\Cart;
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
            'id' => 'required|integer|exists:products',
            'qty' => 'required|integer|min:0',
            'options' => 'array',
        ]);

        $qty = (int) $request->input('qty');

        \Log::debug("Adding item to cart", ['productId' =>$request->input('id'),  'qty' => $qty]);

        $product = Product::find($request->input('id'));

        $cartItem = [
            'id' => (int) $request->input('id'),
            'name' => $product->title,
            'qty' => (int) $request->input('qty'),
            'price' => $product->price,
        ];

        \Log::debug("Current cart has " . Cart::count() . " items");
        \Log::debug(Cart::content());

        //Search for product ID, if exists, update quantity
        if($request->has('options')) {
            $searchResult = Cart::search(['id' => (int) $request->input('id'), 'options' => $request->input('options')]);
            $cartItem['options'] = $request->input('options');
        } else {
            \Log::debug('Searching for cart with item ID: ' . $request->input('id'));
            $searchResult = Cart::search(['id' => (int) $request->input('id')]);
            \Log::debug("Found " . count($searchResult) . " results");
            \Log::debug($searchResult);
        }

        if($searchResult === false) {
            if ($qty > $product->stock_quantity) {
                return response()->json([
                    'status' => 'failure', 'message' => "Unable to add to cart. We only have {$product->stock_quantity} left in stock."
                ], 422); //Unprocessable entity
            }

            \Log::debug('Adding new item to cart: ' . $cartItem['id']);

            Cart::associate('Product', 'App')->add($cartItem);
        } else {
            $rowId = $searchResult[0];

            $totalQuantity = (int) Cart::get($rowId)->qty + $qty;

            if($totalQuantity > $product->stock_quantity) {
                return response()->json([
                    'status' => 'failure', 'message' => "Unable to add to cart. We only have {$product->stock_quantity} left in stock."
                ], 422); //Unprocessable Entity
            }

            \Log::debug("Updating item in cart", ['rowId' => $rowId, 'oldQty' => Cart::get($rowId)->qty, 'newQty' => $totalQuantity]);

            \Log::debug("Session", ['session' => $request->session()->get('cart.main')]);
            Cart::update($rowId, (int) $totalQuantity);

            $cart = $request->session()->get('cart.main');
            \Log::debug("Session", ['session' => $request->session()->get('cart.main')]);
            $request->session()->put('cart.main', $cart);
        }

        return response()->json(['status' => 'success', 'cart' => Cart::content()]);
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

        try {
            Cart::update($rowId, $update);
        } catch(ShoppingcartInvalidRowIDException $e) {
            return response()->json(['status' => 'failure', 'message' => 'The row ID was invalid'], 400);
        }

        return response()->json(['status' => 'success', 'cart' => Cart::content()]);
    }

    /**
     * Remove an item from the cart.
     *
     * @param  int  $rowId
     * @return Response
     */
    public function destroy($rowId)
    {
        try {
            Cart::remove($rowId);
        } catch(ShoppingcartInvalidRowIDException $e) {
            return response()->json(['status' => 'failure', 'message' => 'The row ID was invalid'], 400);
        }


        return response()->json(['status' => 'success']);
    }

    public function test()
    {
        Cart::update('027c91341fd5cf4d2579b49c4b6a90da', 4);

        return response()->json(["please" => 'help me']);
    }
}

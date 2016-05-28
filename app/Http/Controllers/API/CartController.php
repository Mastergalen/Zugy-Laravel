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
     * POST /api/v1/cart
     * Add a new item to cart
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:products',
            'qty' => 'required|integer|min:1',
            'options' => 'array',
        ]);

        $qty = (int) $request->input('qty');

        \Log::debug("Trying to add item to cart", ['productId' =>$request->input('id'),  'qty' => $qty]);

        $product = Product::find($request->input('id'));

        $cartItem = [
            'id' => (int) $request->input('id'),
            'name' => $product->title,
            'qty' => (int) $request->input('qty'),
            'price' => $product->price,
        ];

        //Search for product ID, if exists, update quantity
        if($request->has('options')) {
            $searchResult = Cart::search(['id' => (int) $request->input('id'), 'options' => $request->input('options')]);
            $cartItem['options'] = $request->input('options');
        } else {
            $searchResult = Cart::search(['id' => (int) $request->input('id')]);
        }

        if($searchResult === false) {
            if ($qty > $product->stock_quantity) {
                return response()->json([
                    'status' => 'failure', 'message' => trans('product.out-of-stock', ['quantity' => $product->stock_quantity])
                ], 422); //Unprocessable entity
            }

            Cart::associate('Product', 'App')->add($cartItem);
        } else {
            $rowId = $searchResult[0];

            $totalQuantity = (int) Cart::get($rowId)->qty + $qty;

            if($totalQuantity > $product->stock_quantity) {
                return response()->json([
                    'status' => 'failure', 'message' => trans('product.out-of-stock', ['quantity' => $product->stock_quantity])
                ], 422); //Unprocessable Entity
            }

            Cart::update($rowId, (int) $totalQuantity);

            $cart = $request->session()->get('cart.main');

            $request->session()->put('cart.main', $cart);
        }

        return response()->json(['status' => 'success', 'cart' => Cart::content()]);
    }

    /**
     * Update multiple items in the cart
     * PATCH /api/v1/cart
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function bulkUpdate(Request $request)
    {
        $this->validate($request, [
            'items.*.rowId' => 'required',
            'items.*.name' => 'max:255',
            'items.*.qty' => 'integer|min:0',
            'items.*.options' => 'array',
        ]);

        foreach($request->input('items') as $item) {
            $update = [];

            if(isset($item['name'])) $update['name'] =  $item['name'];
            if(isset($item['qty'])) {
                $update['qty'] = (int) $item['qty'];

                //Check stock
                $stock_quantity = Cart::get($item['rowId'])->product->stock_quantity;

                if($update['qty'] > $stock_quantity) {
                    return response()->json([
                        'status' => 'failure',
                        'message' => trans('product.out-of-stock') . ": " . Cart::get($item['rowId'])->product->title,
                        'description' => trans('product.stock-warning', ['count' => $stock_quantity])
                    ], 422); //Unprocessable Entity
                }
            }
            if(isset($item['options'])) $update['options'] =  $item['options'];

            \Log::debug('Updating cart', ['parameters' => $update]);

            try {
                Cart::update($item['rowId'], $update);
            } catch(ShoppingcartInvalidRowIDException $e) {
                return response()->json(['status' => 'failure', 'message' => 'The row ID was invalid'], 400);
            }
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
}

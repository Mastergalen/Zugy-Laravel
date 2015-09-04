<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Basket;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('demo/product', function () {
    return view('pages.demo.product');
});

Route::get('product/{language}/{slug}', ['uses' => 'ProductController@show']);

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@login']);
    Route::get('login/facebook', 'Auth\AuthController@facebookLogin');
    Route::get('login/google', 'Auth\AuthController@googleLogin');

    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
});

Route::group(['prefix' => 'your-account', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'your-account',function() {
        return view('pages.account.home');
    }]);
});

Route::get('shop', ['uses' => 'ShopController@index']);
Route::get('cart', ['uses' => 'PageController@getCart']);
Route::get('checkout', ['uses' => 'PageController@getCheckout']);

/* API */
Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'v1'], function () {
        //No auth required
        Route::resource('cart', 'API\CartController');
    });
});

//TODO Change middleware to admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('', [function() {
        return view('admin.pages.dash');
    }]);

    Route::resource('catalogue', 'Admin\CatalogueController');
    Route::post('image/upload', 'Admin\ImageController@upload');
});

Route::get('test', function() {
    dd($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    return response()->json(Cart::content());
});

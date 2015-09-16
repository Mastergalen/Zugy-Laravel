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

use App\Events\OrderWasPlaced;
use App\Order;
use App\PaymentMethod;
use App\Services\Order\PlaceOrder;
use Illuminate\Support\Facades\Route;
use Zugy\Facades\Cart;
use Zugy\Facades\PaymentProcessor;
use Zugy\Facades\Shipping;

Route::get('/', function () {
    return view('pages.home');
});

Route::group([
    'prefix' => Localization::setLocale(),
    'middleware' => [ 'localize' ] // Route translate middleware
],
function() {
    Route::get(Localization::transRoute('routes.product'), ['uses' => 'ProductController@show']);

    Route::get(Localization::transRoute('routes.shop'), ['uses' => 'ShopController@index', 'as' => 'shop']);

    /*
     * Checkout
     */
    Route::get(Localization::transRoute('routes.checkout.landing'), ['uses' => 'CheckoutController@getCheckout']);

    //Guest checkout
    Route::get(Localization::transRoute('routes.checkout.guest'), ['uses' => 'CheckoutController@getCheckoutGuest']);

    Route::get(Localization::transRoute('routes.checkout.address'), ['uses' => 'CheckoutController@getCheckoutAddress']);
    Route::post(Localization::transRoute('routes.checkout.address'), ['uses' => 'CheckoutController@postCheckoutAddress']);
    Route::get(Localization::transRoute('routes.checkout.payment'), ['uses' => 'CheckoutController@getCheckoutPayment']);
    Route::post(Localization::transRoute('routes.checkout.payment'), ['uses' => 'CheckoutController@postCheckoutPayment']);
    Route::get(Localization::transRoute('routes.checkout.review'), ['uses' => 'CheckoutController@getCheckoutReview']);
    Route::post(Localization::transRoute('routes.checkout.review'), ['uses' => 'CheckoutController@postCheckoutReview']);
    Route::get(Localization::transRoute('routes.checkout.confirmation'), ['uses' => 'CheckoutController@getCheckoutConfirmation']);

    Route::get(Localization::transRoute('routes.order.show'), ['uses' => 'OrderController@show']);

    /* Cart */
    Route::get(Localization::transRoute('routes.cart'), ['uses' => 'PageController@getCart']);
});

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

Route::get('test', function(PlaceOrder $handler) {
    $order = \App\Order::first();

    //\Event::fire(new OrderWasPlaced($order));

    return view('emails.order-confirmation')->with(compact('order'));
});
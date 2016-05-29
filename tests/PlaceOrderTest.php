<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlaceOrderTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create();
        $this->actingAs($this->user);
    }

    /**
     * Test an order that should be placed without issues.
     * Should fire event OrderWasPlaced
     */
    /*
     * FIXME: Test Disabled until this bug is fixed: https://github.com/laravel/framework/issues/12711
    public function testPlaceOrderPositive()
    {
        $this->expectsEvents(App\Events\OrderWasPlaced::class);

        $product = factory(App\Product::class)->create([
            'stock_quantity' => 10,
        ]);
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $quantity = 5;

        //Add item to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $quantity,
        ])->seeJson(['status' => 'success']);

        $address = factory(App\Address::class)->make();

        $this->user->addresses()->save($address);

        Checkout::setShippingAddress($address);
        Checkout::setBillingAddress($address);

        //Set payment method
        $this->post('en/checkout/payment', [
            'method' => 'cash',
        ]);

        $this->post('/en/checkout/review', [
            'delivery_date' => 'asap'
        ]);
    }
    */

    public function testPlaceOrderOutOfHoursNegative()
    {
        $product = factory(App\Product::class)->create([
            'stock_quantity' => 10,
        ]);
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $quantity = 5;

        //Add item to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $quantity,
        ])->seeJson(['status' => 'success']);

        $address = factory(App\Address::class)->make();

        $this->user->addresses()->save($address);

        Checkout::setShippingAddress($address);
        Checkout::setBillingAddress($address);

        //Set payment method
        $this->post('en/checkout/payment', [
            'method' => 'cash',
        ]);

        $this->post('/en/checkout/review', [
            'delivery_date' => Carbon::now()->addDay(1)->toDateString(),
            'delivery_time' => '06:00' // Out of hours, should fail here
        ], ['HTTP_REFERER' => url('en/checkout/review')])
            ->assertRedirectedTo('en/checkout/review')
            ->followRedirects()
            ->see(trans('checkout.review.delivery-time.error.closed'));
    }

    public function testOrderOutOfStockNegative()
    {
        $product = factory(App\Product::class)->create([
            'stock_quantity' => 10,
        ]);
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $quantity = 5;

        //Add item to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $quantity,
        ])->seeJson(['status' => 'success']);

        $address = factory(App\Address::class)->make();

        $this->user->addresses()->save($address);

        Checkout::setShippingAddress($address);
        Checkout::setBillingAddress($address);

        //Set payment method
        $this->post('en/checkout/payment', [
            'method' => 'cash',
        ]);

        $product->stock_quantity = 3; //Another customer bought 1, only 3 left
        $product->save();

        $this->post('/en/checkout/review', [
            'delivery_date' => Carbon::now()->addDay(1)->toDateString(),
            'delivery_time' => '06:00' // Out of hours, should fail here
        ], ['HTTP_REFERER' => url('en/checkout/review')])
            ->assertRedirectedTo('en/checkout/review')
            ->followRedirects()
            ->see('out of stock');
    }
}

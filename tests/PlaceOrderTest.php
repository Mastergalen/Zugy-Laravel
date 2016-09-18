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
            'delivery_date' => Carbon::now()->addDay(1)->toDateString(),
            'delivery_time' => '18:00'
        ]);

        //Assert that product billing is calculated correctly
        $this->seeInDatabase('order_payments', ['amount' => $quantity * $product->price]);
    }

    /**
     * Should allow order to be placed with ASAP selected when store is open, need to mock time
     */
    public function testPlaceOrderPositiveAsap() {

    }

    /**
     * Should NOT allow order to be placed with ASAP selected when store is closed, need to mock time
     */
    public function testPlaceOrderNegativeAsap() {

    }

    /**
     * Test shipping fee is added correctly for orders under free delivery limit
     */
    public function testPlaceOrderShippingFeePositive()
    {
        $this->expectsEvents(App\Events\OrderWasPlaced::class);

        $product = factory(App\Product::class)->create([
            'stock_quantity' => 10,
            'price' => 5.10
        ]);
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        \Log::debug('product', [$product]);

        $quantity = 2;

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
            'delivery_time' => '18:00'
        ]);

        //Assert that product billing is calculated correctly with shipping fee
        $this->seeInDatabase('order_payments', ['amount' => 10.20 + config('site.shippingFee')]);
    }

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

    /**
     * This test should fail as "asap" delivery time orders cannot be placed when the store is closed
     */
    public function testPlaceAsapOrderOutOfHoursNegative()
    {
        $this->doesntExpectEvents(App\Events\OrderWasPlaced::class);

        $product = factory(App\Product::class)->create([
            'stock_quantity' => 10,
        ]);
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        \Log::debug('product', [$product]);

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

        //Set mock time that is when the store is closed
        $outOfHourTime = Carbon::now()->tomorrow()->hour(4);
        Carbon::setTestNow($outOfHourTime);

        $this->post('/en/checkout/review', [
            'delivery_date' => 'asap'
        ])->followRedirects()
            ->see(trans('opening-times.prompt-select')); //Should see the out of hours error message
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

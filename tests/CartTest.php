<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();

        $this->user = factory(App\User::class)->create();
        $this->actingAs($this->user);
    }

    /**
     * Test adding something to cart
     *
     * @return void
     */
    public function testAddToCart()
    {
        $product = factory(App\Product::class)->create();
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $quantity = $this->faker->numberBetween(1, $product->stock_quantity);

        //Add item to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $quantity,
        ])->seeJson(['status' => 'success']);

        $this->json('GET', 'api/v1/cart')->seeJson([
            'id' => $product->id,
            'qty' => $quantity,
            'price' => number_format($product->price,2),
            'subtotal' => round($product->price * $quantity, 2)
        ]);
    }

    /**
     * Test updating quantity in cart
     */
    public function testAddExistingCart() {
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

        $secondQuantity = 2;

        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $secondQuantity,
        ])->seeJson(['status' => 'success']);

        $this->json('GET', 'api/v1/cart')->seeJson([
            'id' => $product->id,
            'qty' => $quantity + $secondQuantity,
            'price' => number_format($product->price,2),
            'subtotal' => round($product->price * ($quantity + $secondQuantity), 2)
        ]);
    }

    /**
     * Test if out stock error works when bulk updating existing items in cart
     */
    public function testUpdateOutOfStock() {
        $product = factory(App\Product::class)->create([
            'stock_quantity' => 10,
        ]);
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $quantity = 5;

        //Add item to cart
        $response = $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $quantity,
        ])->seeJson(['status' => 'success']);

        $json = json_decode($response->response->getContent(), true);

        $rowId = key($json['cart']);

        $newQuantity = 4;

        $this->json('PATCH', 'api/v1/cart', [
            'items' => [
                [
                    'rowId' => $rowId,
                    'qty' => $newQuantity,
                ]
            ]
        ])->seeJson(['status' => 'success', 'qty' => $newQuantity]);
    }

    /**
     * Test if out of stock error works when adding new item
     * @return void
     */
    public function testAddOutOfStock() {
        $product = factory(App\Product::class)->create();
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $quantity = $product->stock_quantity + 1; //Just one over the max. stock

        //Add item to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => $quantity,
        ])->seeJson(['status' => 'failure', 'message' => 'Out of stock']);

        $this->json('GET', 'api/v1/cart')->seeJsonEquals([]); //Should be empty
    }
}

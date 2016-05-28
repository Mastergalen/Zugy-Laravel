<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Zugy\Facades\Stock;

class StockTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Check that stock check passes
     *
     * @return void
     */
    public function testStockPositive()
    {
        $productA = factory(App\Product::class)->create(['stock_quantity' => 4]);
        $productA->translations()->save(factory(App\ProductTranslation::class)->make());

        $productB = factory(App\Product::class)->create(['stock_quantity' => 3]);
        $productB->translations()->save(factory(App\ProductTranslation::class)->make());

        //Add 4 of productA to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $productA->id,
            'qty' => 4,
        ])->seeJson(['status' => 'success']);

        //Add 2 of productB to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $productB->id,
            'qty' => 2,
        ])->seeJson(['status' => 'success']);

        $this->assertTrue(Stock::checkCartStock());
    }

    /**
     * Check that stock check throws correct error
     */
    public function testStockNegative() {
        $this->setExpectedException('App\Exceptions\OutOfStockException');

        $productA = factory(App\Product::class)->create(['stock_quantity' => 4]);
        $productA->translations()->save(factory(App\ProductTranslation::class)->make());

        $productB = factory(App\Product::class)->create(['stock_quantity' => 3]);
        $productB->translations()->save(factory(App\ProductTranslation::class)->make());

        //Add 4 of productA to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $productA->id,
            'qty' => 4,
        ])->seeJson(['status' => 'success']);

        //Add 2 of productB to cart
        $this->json('POST', 'api/v1/cart', [
            'id' => $productB->id,
            'qty' => 2,
        ])->seeJson(['status' => 'success']);

        \Log::debug('Updating product stock', [$productA->id]);
        $productA->stock_quantity = 3; //Another customer bought 1, only 3 left
        $productA->save();

        Stock::checkCartStock(); //Should throw OutOfStockException
    }
}

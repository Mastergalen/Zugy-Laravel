<?php

class ProductTest extends TestCase
{
    public function testProductShow()
    {
        $product = \App\Product::first();

        $this->visit($product->getUrl())
             ->see($product->title);

        //$this->visit('it/prodotto/absolut-vodka')->see('Absolut Vodka');
    }

    public function testAlcoholCategoryShow()
    {
        $this->visit('en/shop/category/alcohol')->see('Alcohol');
    }
}
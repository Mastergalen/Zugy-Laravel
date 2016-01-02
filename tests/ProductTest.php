<?php

class ProductTest extends TestCase
{
    public function testProductShow()
    {
        $this->visit('en/product/absolut-vodka')
             ->see('Absolut Vodka');

        //$this->visit('it/prodotto/absolut-vodka')->see('Absolut Vodka');
    }

    public function testAlcoholCategoryShow()
    {
        $this->visit('en/shop/category/alcohol')->see('Alcohol');
    }
}
<?php

class ProductTest extends TestCase
{
    public function testProductShow()
    {
        $this->visit('product/absolut-vodka')
             ->see('Absolut Vodka');

        //$this->visit('it/prodotto/absolut-vodka')->see('Absolut Vodka');
    }
}
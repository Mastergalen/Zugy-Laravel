<?php

namespace App\Exceptions;

use App\Language;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class OutOfStockException extends \Exception
{
    protected $products = []; //Array of products that are out of stock

    public function __construct($products) {
        $this->products = $products;
    }

    public function getProducts() {
        return $this->products;
    }

    public function getErrorMessages() {
        $errors = [];
        $language_id = Language::getLanguageId(LaravelLocalization::getCurrentLocale());

        foreach($this->products as $p) {
            if($p->stock_quantity == 0) {
                $errors[] = "{$p->title} is out of stock. Please remove the item from your cart to place your order."; //FIXME Show item name
            } else {
                $errors[] = "{$p->title} only has {$p->stock_quantity} units left in stock. Please reduce the order quantity in your cart to place your order.";
            }
        }

        return $errors;
    }
}
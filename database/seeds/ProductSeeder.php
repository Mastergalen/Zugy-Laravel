<?php
use App\Product;
use Illuminate\Database\Seeder;

/**
 * User: Galen Han
 * Date: 05.09.2015
 * Time: 20:22
 */
class ProductSeeder extends Seeder
{
    public function run() {
        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 12.99,
            'compare_price' => 19.99,
            'weight' => 0.50,
            'tax_class_id' => 1,
        ]);

        $product->description()->create([
            'language_id' => 1,
            'title' => 'Absolut Vodka',
            'slug' => 'absolut-vodka',
            'description' => 'Absolut Vodka is a Swedish vodka made exclusively from natural ingredients, and unlike some other vodkas, it doesn�t contain any added sugar. In fact Absolut is as clean as vodka can be. Still, it has a certain taste: Rich, full-bodied and complex, yet smooth and mellow with a distinct character of grain, followed by a hint of dried fruit.',
            'meta_description' => 'Buy Absolut Vokda online from Zugy today.',
        ]);

        $product->attributes()->attach(1, ['value' => 0.350]); //Volume
        $product->attributes()->attach(2, ['value' => 40.0]); //% Vol
    }
}
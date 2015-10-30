<?php
use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run() {
        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 12.99,
            'compare_price' => 19.99,
            'weight' => 0.50,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Absolut Vodka',
                'slug' => 'absolut-vodka',
                'description' => 'Absolut Vodka is a Swedish vodka made exclusively from natural ingredients, and unlike some other vodkas, it doesn\'t contain any added sugar. In fact Absolut is as clean as vodka can be. Still, it has a certain taste: Rich, full-bodied and complex, yet smooth and mellow with a distinct character of grain, followed by a hint of dried fruit.',
                'meta_description' => 'Buy Absolut Vokda online from Zugy today.',
            ],
            'it' => [
                'title' => 'Absolut Vodka',
                'slug' => 'absolut-vodka',
                'description' => 'Absolut una marca svedese di vodka, della V&S Group, prodotta a hus, Scania nel sud della Svezia.',
                'meta_description' => 'Acquista online da Absolut vokda Zugy oggi.',
            ]
        ]);

        $product->categories()->attach(5); //Vodka category

        $product->attributes()->attach(1, ['value' => 0.350]); //Volume
        $product->attributes()->attach(2, ['value' => 40.0]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/absolut-vodka/absolut-vodka.jpeg');
        Storage::disk('uploads')->put('demo/absolut-vodka/absolut-vodka.jpeg', $img);

        $product->images()->create([
           'location' => 'demo/absolut-vodka/absolut-vodka.jpeg'
        ]);

        ####

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 15.00,
            'compare_price' => 16.36,
            'weight' => 0.50,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Bacardi 70cl',
                'slug' => 'bacardi',
                'description' => "<p>Bacardi's original, the Superior is a highly versatile white Rum which has been around since 1862.</p><p>Aged in oak barrels, look out for the smooth taste and the almond and tropical fruit aroma.</p>",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Bacardi 70cl',
                'slug' => 'bacardi',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(6); //Rum category

        $product->attributes()->attach(1, ['value' => 0.700]); //Volume
        $product->attributes()->attach(2, ['value' => 37.5]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/bacardi/bacardi.jpg');
        Storage::disk('uploads')->put('demo/bacardi/bacardi.jpg', $img);

        $product->images()->create([
            'location' => 'demo/bacardi/bacardi.jpg'
        ]);
    }
}
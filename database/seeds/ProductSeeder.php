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

        ####

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 15.00,
            'compare_price' => 16.57,
            'weight' => 0.80,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Havana Club 70cl',
                'slug' => 'havana',
                'description' => "",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Havana Club 70cl',
                'slug' => 'havana',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(6); //Rum category

        $product->attributes()->attach(1, ['value' => 0.700]); //Volume
        $product->attributes()->attach(2, ['value' => 40.0]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/havana/havana.jpg');
        Storage::disk('uploads')->put('demo/havana/havana.jpg', $img);

        $product->images()->create([
            'location' => 'demo/havana/havana.jpg'
        ]);

        ####

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 3.00,
            'compare_price' => null,
            'weight' => 0.60,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Heineken',
                'slug' => 'heineken',
                'description' => "",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Heineken',
                'slug' => 'heineken',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(7); //Beer category

        $product->attributes()->attach(1, ['value' => 0.660]); //Volume
        $product->attributes()->attach(2, ['value' => 5]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/heineken/heineken.jpg');
        Storage::disk('uploads')->put('demo/heineken/heineken.jpg', $img);

        $product->images()->create([
            'location' => 'demo/heineken/heineken.jpg'
        ]);

        ###

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 2.50,
            'compare_price' => null,
            'weight' => 0.60,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Peroni',
                'slug' => 'peroni',
                'description' => "",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Peroni',
                'slug' => 'peroni',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(7); //Beer category

        $product->attributes()->attach(1, ['value' => 0.660]); //Volume
        $product->attributes()->attach(2, ['value' => 5.1]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/peroni/peroni.jpg');
        Storage::disk('uploads')->put('demo/peroni/peroni.jpg', $img);

        $product->images()->create([
            'location' => 'demo/peroni/peroni.jpg'
        ]);

        ###

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 28.00,
            'compare_price' => 37.15,
            'weight' => 0.60,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Sauza Silver Tequila 100cl',
                'slug' => 'sauza-silver',
                'description' => "",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Sauza Silver Tequila 100cl',
                'slug' => 'sauza-silver',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(8); //Tequila category

        $product->attributes()->attach(1, ['value' => 1.0]); //Volume
        $product->attributes()->attach(2, ['value' => 40.0]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/sauza-tequila/sauza-tequila.jpg');
        Storage::disk('uploads')->put('demo/sauza-tequila/sauza-tequila.jpg', $img);

        $product->images()->create([
            'location' => 'demo/sauza-tequila/sauza-tequila.jpg'
        ]);

        ###

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 90.00,
            'compare_price' => 128.10,
            'weight' => 0.60,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Veuve Clicquot Champagne',
                'slug' => 'veuve-clicquot',
                'description' => "Veuve Clicquot",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Peroni',
                'slug' => 'veuve-clicquot',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(4); //Wine & champagne category

        $product->attributes()->attach(1, ['value' => 0.750]); //Volume
        $product->attributes()->attach(2, ['value' => 12]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/veuve-clicquot/veuve-clicquot.jpg');
        Storage::disk('uploads')->put('demo/veuve-clicquot/veuve-clicquot.jpg', $img);

        $product->images()->create([
            'location' => 'demo/veuve-clicquot/veuve-clicquot.jpg'
        ]);

        ###

        $product = Product::create([
            'stock_quantity' => 10,
            'price' => 90.00,
            'compare_price' => 128.10,
            'weight' => 0.60,
            'tax_class_id' => 1,

            'en' => [
                'title' => 'Moet And Chandon Brut Imperial Non Vintage Champagne',
                'slug' => 'moet-chandon-imperial',
                'description' => "",
                'meta_description' => '',
            ],
            'it' => [
                'title' => 'Moet And Chandon Brut Imperial Champagne',
                'slug' => 'moet-chandon-imperial',
                'description' => '',
                'meta_description' => '',
            ]
        ]);

        $product->categories()->attach(4); //Wine & champagne category

        $product->attributes()->attach(1, ['value' => 0.750]); //Volume
        $product->attributes()->attach(2, ['value' => 12]); //% Vol

        $img = Storage::disk('public')->get('img/demo/products/moet-chandon-imperial/moet-chandon-imperial.jpg');
        Storage::disk('uploads')->put('demo/moet-chandon-imperial/moet-chandon-imperial.jpg', $img);

        $product->images()->create([
            'location' => 'demo/moet-chandon-imperial/moet-chandon-imperial.jpg'
        ]);
    }
}
<?php
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run() {
        DB::table('categories')->insert([
            ['id' => 1, 'parent_id' => null],
            ['id' => 2, 'parent_id' => null],
            ['id' => 3, 'parent_id' => 1],
            ['id' => 4, 'parent_id' => 1],
            ['id' => 5, 'parent_id' => 3],
            ['id' => 6, 'parent_id' => 3],
            ['id' => 7, 'parent_id' => 1],
            ['id' => 8, 'parent_id' => 3],
            ['id' => 9, 'parent_id' => 3],
            ['id' => 10, 'parent_id' => 1],
            ['id' => 11, 'parent_id' => 3],
            ['id' => 12, 'parent_id' => null], //Mixers
            ['id' => 13, 'parent_id' => 12], //Soda
            ['id' => 14, 'parent_id' => 12], //Juice
            ['id' => 15, 'parent_id' => 12], //Energy drinks
        ]);

        DB::table('category_translations')->insert([
            ['category_id' => 1, 'locale' => 'en',  'name' => 'Alcohol', 'slug' => 'alcohol'],
            ['category_id' => 1, 'locale' => 'it',  'name' => 'Alcol', 'slug' => 'alcol'],

            ['category_id' => 2, 'locale' => 'en',  'name' => 'Food', 'slug' => 'food'],
            ['category_id' => 2, 'locale' => 'it',  'name' => 'Cibo', 'slug' => 'cibo'],

            ['category_id' => 3, 'locale' => 'en',  'name' => 'Spirits', 'slug' => 'spirits'],
            ['category_id' => 3, 'locale' => 'it',  'name' => 'Spirits', 'slug' => 'spirits'],

            ['category_id' => 4, 'locale' => 'en',  'name' => 'Wine & champagne', 'slug' => 'wine-and-champagne'],
            ['category_id' => 4, 'locale' => 'it',  'name' => 'Vino e champagne', 'slug' => 'vino-e-champagne'],

            ['category_id' => 5, 'locale' => 'en',  'name' => 'Vodka', 'slug' => 'vodka'],
            ['category_id' => 5, 'locale' => 'it',  'name' => 'Vodka', 'slug' => 'vodka'],

            ['category_id' => 6, 'locale' => 'en',  'name' => 'Rum', 'slug' => 'rum'],
            ['category_id' => 6, 'locale' => 'it',  'name' => 'Rum', 'slug' => 'rum'],

            ['category_id' => 7, 'locale' => 'en',  'name' => 'Beer', 'slug' => 'beer'],
            ['category_id' => 7, 'locale' => 'it',  'name' => 'Birra', 'slug' => 'birra'],

            ['category_id' => 8, 'locale' => 'en',  'name' => 'Tequila', 'slug' => 'tequila'],
            ['category_id' => 8, 'locale' => 'it',  'name' => 'Tequila', 'slug' => 'tequila'],

            ['category_id' => 9, 'locale' => 'en',  'name' => 'Whiskey', 'slug' => 'whiskey'],
            ['category_id' => 9, 'locale' => 'it',  'name' => 'Whisky', 'slug' => 'whisky'],

            ['category_id' => 10, 'locale' => 'en',  'name' => 'Special', 'slug' => 'special'],
            ['category_id' => 10, 'locale' => 'it',  'name' => 'Speciale', 'slug' => 'speciale'],

            ['category_id' => 11, 'locale' => 'en',  'name' => 'Gin', 'slug' => 'gin'],
            ['category_id' => 11, 'locale' => 'it',  'name' => 'Gin', 'slug' => 'gin'],

            ['category_id' => 12, 'locale' => 'en',  'name' => 'Mixers', 'slug' => 'mixers'],
            ['category_id' => 12, 'locale' => 'it',  'name' => 'Mixers', 'slug' => 'mixers'],

            ['category_id' => 13, 'locale' => 'en',  'name' => 'Soda', 'slug' => 'soda'],
            ['category_id' => 13, 'locale' => 'it',  'name' => 'Soda', 'slug' => 'soda'],

            ['category_id' => 14, 'locale' => 'en',  'name' => 'Juice', 'slug' => 'juice'],
            ['category_id' => 14, 'locale' => 'it',  'name' => 'Succo', 'slug' => 'succo'],

            ['category_id' => 15, 'locale' => 'en',  'name' => 'Energy Drinks', 'slug' => 'energy-drinks'],
            ['category_id' => 15, 'locale' => 'it',  'name' => 'Bevande energetiche', 'slug' => 'bevande-energetiche'],
        ]);
    }
}

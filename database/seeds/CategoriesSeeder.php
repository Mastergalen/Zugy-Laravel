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
            ['id' => 5, 'parent_id' => 4],
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
        ]);
    }
}
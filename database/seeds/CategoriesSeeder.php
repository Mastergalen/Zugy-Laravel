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

        DB::table('categories_description')->insert([
            ['category_id' => 1, 'language_id' => 1,  'name' => 'Alcohol'],
            ['category_id' => 1, 'language_id' => 2,  'name' => 'Alcol'],
            ['category_id' => 2, 'language_id' => 1,  'name' => 'Food'],
            ['category_id' => 3, 'language_id' => 1,  'name' => 'Spirits'],
            ['category_id' => 4, 'language_id' => 1,  'name' => 'Wine & champagne'],
            ['category_id' => 5, 'language_id' => 1,  'name' => 'Vodka'],
        ]);
    }
}
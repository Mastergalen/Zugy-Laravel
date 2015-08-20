<?php
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    public function run() {
        DB::table('attributes')->insert([
            ['id' => 1],
            ['id' => 2]
        ]);

        DB::table('attributes_description')->insert([
            ['attribute_id' => 1, 'language_id' => 1, 'name' => 'Volume'],
            ['attribute_id' => 2, 'language_id' => 1, 'name' => 'Alcohol Content']
        ]);
    }
}
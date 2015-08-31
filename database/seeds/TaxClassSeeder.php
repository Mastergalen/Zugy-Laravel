<?php
use Illuminate\Database\Seeder;

class TaxClassSeeder extends Seeder
{
    public function run() {
        DB::table('tax_classes')->insert([
            ['id' => 1, 'title' => 'Alcohol', 'description' => 'Alcoholic Beverages', 'tax_rate' => '22.0'],
            ['id' => 2, 'title' => 'Food', 'description' => '', 'tax_rate' => '4.0']
        ]);
    }
}
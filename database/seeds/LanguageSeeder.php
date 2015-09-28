<?php
use Illuminate\Database\Seeder;

/**
 * User: Galen Han
 * Date: 24.07.2015
 * Time: 15:48
 */
class LanguageSeeder extends Seeder
{
    public function run() {
        DB::table('languages')->insert([
            ['id' => 1, 'name' => 'English', 'code' => 'en', 'flag' => 'gb'],
            ['id' => 2, 'name' => 'Italian', 'code' => 'it', 'flag' => 'it']
        ]);
    }
}
<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CountriesSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(TaxClassSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(AttributesSeeder::class);

        Model::reguard();
    }
}

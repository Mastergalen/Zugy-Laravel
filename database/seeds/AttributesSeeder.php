<?php
use App\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    public function run() {
        Model::unguard();

        Attribute::create()->description()->create([
           'language_id' => 1, 'name' => 'Volume', 'unit' => 'litres'
        ]);

        Attribute::create()->description()->create([
            'language_id' => 2, 'name' => 'Volume', 'unit' => 'litri'
        ]);

        Attribute::create()->description()->create([
            'language_id' => 1, 'name' => 'Alcohol Content', 'unit' => '% Vol'
        ]);

        Attribute::create()->description()->create([
            'language_id' => 2, 'name' => 'Grado alcolico', 'unit' => '% Vol'
        ]);
    }
}
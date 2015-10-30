<?php
use App\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    public function run() {
        Model::unguard();

        Attribute::create([
            'id' => 1,
            'en' => [
                'name' => 'Volume',
                'unit' => 'litres'
            ],
            'it' => [
                'name' => 'Volume',
                'unit' => 'litri'
            ]
        ]);

        Attribute::create([
            'id' => 2,
            'en' => [
                'name' => 'Alcohol Content',
                'unit' => '% Vol'
            ],
            'it' => [
                'name' => 'Grado alcolico',
                'unit' => '% Vol'
            ]
        ]);
    }
}
<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'group_id' => 0
    ];
});

$factory->defineAs(App\User::class, 'admin', function($faker)  use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['group_id' => 2]);
});


$factory->define(App\Address::class, function($faker) {
    return [
        'name' => $faker->name,
        'line_1' => $faker->streetAddress,
        'city' => 'Milan',
        'postcode' => 20121,
        'country_id' => 380, //Italy
        'phone' => $faker->phoneNumber,
        'delivery_instructions' => $faker->text(),
    ];
});

$factory->define(App\Product::class, function($faker) {
    return [
        'stock_quantity' => $faker->numberBetween(1, 10000),
        'price' => $faker->randomNumber(2),
        'compare_price' => null,
        'weight' => $faker->randomFloat(2, 0, 100),
        'tax_class_id' => 1,
        'thumbnail_id' => null
    ];
});

$factory->define(App\ProductTranslation::class, function($faker) {
    return [
        'locale' => 'en',
        'slug' => $faker->slug,
        'title' => $faker->sentence(),
        'description' => $faker->sentence(),
        'meta_description' => $faker->sentence()
    ];
});
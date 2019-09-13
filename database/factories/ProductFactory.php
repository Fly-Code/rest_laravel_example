<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entities\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'active' => rand(0, 1),
        'price' => rand(100, 100000),
        'in_stock' => rand(0, 10),
    ];
});

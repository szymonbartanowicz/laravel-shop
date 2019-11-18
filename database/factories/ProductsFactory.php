<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
//use Faker\Generator as Faker;

$factory->define(Product::class, function () {
    $faker = \Faker\Factory::create();
    $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
    return [
        'name' => $faker->productName,
        'price' => $faker->randomDigitNotNull,
        'active' => $faker->boolean,
        'qty' => 1,
    ];
});

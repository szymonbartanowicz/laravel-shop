<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'number' => $faker->randomNumber(6),
        'total' => 0,
        'status' => 'new',
    ];
});

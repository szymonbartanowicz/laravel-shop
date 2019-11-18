<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'company' => $faker->company,
        'phone_number' => $faker->phoneNumber,
        'city' => $faker->city,
        'street_name' => $faker->streetName,
        'street_number' => $faker->buildingNumber,
    ];
});

<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'order_id' => 1,
        'product_id' => 1,
        'qty' => 1,
    ];
});

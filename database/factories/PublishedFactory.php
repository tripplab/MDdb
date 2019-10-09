<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Published::class, function (Faker $faker) {
    return [
        'DOIpreprint' => $faker->randomAscii,
        'DOIpaper' => $faker->randomAscii,
    ];
});

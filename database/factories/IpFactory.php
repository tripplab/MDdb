<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Ip::class, function (Faker $faker) {
    return [
        'address' => $faker->ipv4,
        'lng' => $faker->longitude,
        'lat' => $faker->latitude,
        'country' => $faker->country,
        'region' => $faker->name,
        'city' => $faker->city,
        'isp' => $faker->randomAscii,
        'organization' => $faker->name,
    ];
});

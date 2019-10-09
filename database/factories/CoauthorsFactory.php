<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Coauthors::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address' => $faker->address,
        'email' => $faker->email,
        'place_in_list' => $faker->randomDigit,
    ];
});

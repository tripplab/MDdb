<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Author::class, function (Faker $faker) {
    return [
        'is_active' => $faker->boolean(),
        'is_premium' => $faker->boolean,
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'llave' => $faker->password,
        'url' => $faker->url,
    ];
});

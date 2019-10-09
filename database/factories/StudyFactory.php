<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Study::class, function (Faker $faker) {
    $filepath = storage_path('avatars');

    if(!File::exists($filepath)){
        File::makeDirectory($filepath);
    }

    $study_skeleton = [
        'title' => "Hot-spots and their contribution to the self-assembly of the viral capsid: in-silico prediction and analysis",
        'short_title' => "Hot-spots and their contribution viral capsid",
        'abstract' => "In order to rationally design biopolymers that mimic biological functions, first, we need to elucidate the molecular mechanisms followed by nature.",
    ];

    $data = [
        'title' => $faker->text(150),
        'short_title' => $faker->text(250),
        'abstract' => $faker->text(500),
        'funding' => $faker->text(),
        'pipe_config' => $faker->file(public_path(), $filepath),
        'approved_at' => $faker->dateTime,
        'is_public' => $faker->boolean(),
        'llave' => $faker->password(),
    ];

    return $data;
});

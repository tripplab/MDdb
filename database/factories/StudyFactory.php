<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Study::class, function (Faker $faker) {
    $filepath = storage_path('avatars');

    if(!File::exists($filepath)){
        File::makeDirectory($filepath);
    }

    return [
        'title' => "Hot-spots and their contribution to the self-assembly of the viral capsid: in-silico prediction and analysis",
        'short_title' => "Hot-spots and their contribution to the self-assembly of the viral capsid: in-silico prediction and analysis",
        'abstract' => "In order to rationally design biopolymers that mimic biological functions, first, we need to elucidate the molecular mechanisms followed by nature.",
        'pipe_config' => $faker->image($filepath,400, 300),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word() . '-document',
        'file_path' => 'Documents/' . $faker->unique()->word() . '-document.pdf'
    ];
});

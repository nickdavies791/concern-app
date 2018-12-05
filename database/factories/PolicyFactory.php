<?php

use Faker\Generator as Faker;

$factory->define(App\Policy::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word() . '-policy',
        'file_path' => 'Documents/' . $faker->unique()->word() . '-policy.pdf'
    ];
});

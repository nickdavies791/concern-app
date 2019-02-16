<?php

use Faker\Generator as Faker;

$factory->define(App\School::class, function (Faker $faker) {
    return [
        'urn' => $faker->numberBetween(100000, 140000),
        'name' => $faker->company,
        'headteacher' => $faker->name,
        'la_name' => $faker->company,
        'street' => $faker->streetName,
        'town' => $faker->city,
        'postcode' => $faker->postcode
    ];
});

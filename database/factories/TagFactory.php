<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement($array = array ('Bullying', 'Mental Health', 'Neglect', 'Suicidal Thoughts', 'Violence'))
    ];
});

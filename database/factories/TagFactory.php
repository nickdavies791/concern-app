<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    $tags = [
        'Domestic Abuse',
        'Sexual Abuse',
        'Neglect',
        'Welfare',
        'Physical Abuse',
        'Emotional Abuse',
        'Child Sexual Exploitation',
        'Female Genital Mutilation',
        'Bullying',
        'Cyberbullying',
        'Injury',
        'Mental Health',
        'Behaviour',
    ];

    return [
        'name' => $faker->randomElement($tags)
    ];
});

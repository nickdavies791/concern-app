<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        'admission_number' => $faker->unique()->randomNumber(6, true),
        'upn' => $faker->unique()->regexify("[a-f0-9]{6}"),
        'forename' => $faker->firstName(),
        'surname' => $faker->lastName(),
        'year_group' => $faker->numberBetween($min = 7, $max = 13),
        'birth_date' => ($faker->dateTimeBetween($startDate = '-15 years', $endDate = '-10 years', $timezone = 'Europe/London'))->format('Y-m-d')
    ];
});

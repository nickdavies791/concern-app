<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    $groups = [
        'All Staff',
        'Attendance',
        'Behavioural',
        'Learning Support',
        'Safeguarding',
        'Senior Leadership',
        'Year Leads',
    ];
    return [
        'name' => $faker->unique()->randomElement($groups)
    ];
});

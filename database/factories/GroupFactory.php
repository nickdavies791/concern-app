<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement($array = array ('SLT','Safeguarding','Year Leads', 'Behavioural', 'Pastoral'))
    ];
});

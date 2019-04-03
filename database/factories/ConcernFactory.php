<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Concern::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User')->create()->id,
        'type' => $faker->randomElement(['Observation', 'Disclosure']),
        'body' => $faker->paragraph(),
        'concern_date' => $faker->dateTimeBetween(Carbon::now()->subMonths(7)->toDateTimeString(), 'now')->format('Y-m-d h:i:s'),
        'resolved_on' => function() use($faker){
            return $faker->boolean(25) ? Carbon::now() : null;   
        }
    ];
});

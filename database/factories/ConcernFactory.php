<?php

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Concern::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return (User::inRandomOrder()->first())->id;
        },
        'type' => $faker->randomElement(['Observation', 'Disclosure']),
        'body' => $faker->paragraph(),
        'concern_date' => now(),
        'resolved_on' => function() use($faker){
            $isResolved = $faker->boolean(25);
            if($isResolved)
            {
                return Carbon::now();
            }
            return null;
        }
    ];
});

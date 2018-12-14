<?php

use App\User;
use App\Group;
use App\Student;
use Faker\Generator as Faker;

$factory->define(App\Concern::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return (User::inRandomOrder()->first())->id;
        },
        'group_id' => function(){
            return (Group::inRandomOrder()->first())->id;
        },
        'title' => $faker->sentence(),
        'concern_date' => now(),
        'resolved_on' => function() use($faker){
            $coin = $faker->boolean($chanceOfGettingTrue = 50);

            if($coin){
                return $faker->dateTimeThisYear($max = 'now', $timezone = 'Europe/London');
            }

            return null;
        }
    ];
});

<?php

use App\Concern;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'concern_id' => function(){
            return (Concern::inRandomOrder()->first())->id;
        },
        'user_id' => function(){
            return (User::inRandomOrder()->first())->id;
        },
        'body' => $faker->paragraph(),
        'action_taken' => $faker->paragraph()
    ];
});

<?php

use App\Concern;
use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'concern_id' => function(){
            return (Concern::inRandomOrder()->first())->id;
        },
        'title' => $faker->sentence(),
        'comment' => $faker->paragraph(),
        'action_taken' => $faker->paragraph()
    ];
});

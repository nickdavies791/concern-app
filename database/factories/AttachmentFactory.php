<?php

use Faker\Generator as Faker;

$factory->define(App\Attachment::class, function (Faker $faker) {
    return [
        'concern_id' => factory('App\Concern')->create()->id,
        'file_name' => $faker->slug()
    ];
});

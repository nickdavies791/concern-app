<?php

use App\Student;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Exclusion::class, function (Faker $faker) {
    return [
        'student_id' => Student::all()->random()->id,
        'type' => $faker->word,
        'reason' => $faker->paragraph,
        'start_date' => Carbon::now()->subMonth(),
        'start_session' => 'AM',
        'end_date' => Carbon::now()->subWeek(),
        'end_session' => 'PM',
        'length' => $faker->numberBetween(0,14)
    ];
});

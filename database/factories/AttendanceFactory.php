<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Attendance::class, function (Faker $faker) {
    return [
        'student_id' => $faker->randomNumber(),
        'start_date' => Carbon::now()->subWeek(),
        'end_date' => Carbon::now(),
        'possible_sessions' => 100,
        'attended_sessions' => $faker->numberBetween(0,100),
        'late_sessions' => $faker->numberBetween(0,100),
        'authorised_absence_sessions' => $faker->numberBetween(0,100),
        'unauthorised_absence_sessions' => $faker->numberBetween(0,100)
    ];
});

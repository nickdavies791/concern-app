<?php

use App\Concern;
use App\Student;
use Illuminate\Database\Seeder;

class ConcernStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Concern::all()->each( function ($concern) {
            $students = range(1, 1000);
            shuffle($students);
            $concern->students()->attach(array_slice($students, 0, rand(1, 3)));
        });
    }
}

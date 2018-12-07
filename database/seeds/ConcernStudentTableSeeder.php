<?php

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
        Student::all()->each(function ($student){
            //Policy seeder makes 5 policies
            $concerns = range(1, 500);
            //shuffle array to get random order;
            shuffle($concerns);
            //attach random policies to each user
            $student->concerns()->attach(array_slice($concerns, 0, rand(1, 6)));
        });
    }
}

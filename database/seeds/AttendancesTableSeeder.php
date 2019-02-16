<?php

use App\Student;
use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::all()->each( function ($student) {
            factory('App\Attendance')->create([
                'student_id' => $student->id
            ]);
        });
    }
}

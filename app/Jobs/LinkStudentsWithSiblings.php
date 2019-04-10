<?php

namespace App\Jobs;

use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LinkStudentsWithSiblings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $students;

    /**
     * Create a new job instance.
     *
     * @param $students
     */
    public function __construct($students)
    {
        $this->students = $students;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->students->filter(function ($student) {
            return $student->siblings != null;
        })->each(function ($studentData) {
            // Formats the siblings into arrays so they can be synced properly
            $siblings = collect($studentData->siblings)->flatten(1)->pluck('student_id');

            Student::whereMisId($studentData->mis_id)
                ->first()
                ->siblings()
                ->syncWithoutDetaching($siblings);
        });
    }
}

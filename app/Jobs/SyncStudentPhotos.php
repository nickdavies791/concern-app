<?php

namespace App\Jobs;

use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncStudentPhotos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $students;

    protected $storage;

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
            // Only the students with photos
            return $student->photo != null; 
        })->filter(function ($studentData) {
            //Only students with changed photos
            $student = Student::whereMisId($studentData->mis_id)->first();
            return $student->photo_hash != $studentData->photo->hash;
        })->each(function ($studentData) {
            $this->storeImage($studentData->mis_id, $studentData->photo);
        });
    }

    /**
     * Stores image from API on students disk
     *
     * @param integer $studentId
     * @param object $studentPhoto
     * @return void
     */
    private function storeImage($studentId, $studentPhoto)
    {
        \Storage::disk('students')->put("{$studentId}.jpg", file_get_contents($studentPhoto->url));

        $student = Student::whereMisId($studentId)->first();
        $student->update(['photo_hash' => $studentPhoto->hash]);
    }
}

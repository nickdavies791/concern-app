<?php

namespace App\Jobs;

use App\Services\Interfaces\MISInterface;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param MISInterface $mis
     * @param Student $student
     * @return void
     */
    public function handle(MISInterface $mis, Student $student)
    {
        $students = collect( $mis->getStudents())->mapWithKeys(function ($student) {
            return [
                $student->id => (object)[
                    'id' => $student->id,
                    'mis_id' => $student->mis_id,
                    'admission_number' => $student->pan,
                    'upn' => $student->upn,
                    'forename' => $student->first_name,
                    'surname' => $student->last_name,
                    'year_group' => $student->year_code,
                    'birth_date' => $student->dob,
                    'ever_in_care' => $student->demographics->ever_in_care,
                    'sen_category' => $student->demographics->sen_category,
                    'photo' => $student->photo,
                    'siblings' => $student->siblings
                ]
            ];
        });
        
        $students->each(function ($studentData) use($student){
            try {
                $student->updateOrCreate(['mis_id' => $studentData->mis_id],
                    [
                        'id' => $studentData->id,
                        'mis_id' => $studentData->mis_id,
                        'admission_number' => $studentData->admission_number,
                        'upn' => $studentData->upn,
                        'forename' => $studentData->forename,
                        'surname' => $studentData->surname,
                        'year_group' => $studentData->year_group,
                        'birth_date' => $studentData->birth_date,
                        'ever_in_care' => $studentData->ever_in_care,
                        'sen_category' => $studentData->sen_category,
                    ]
                );
            } catch (\Exception $e) {
                info('Error: ', ['Error: ' => $e]);
            }
        });

        dispatch(new LinkStudentsWithSiblings($students));
        dispatch(new SyncStudentPhotos($students));
        dispatch(new GetAttendance());
        dispatch(new GetExclusions());
    }
}

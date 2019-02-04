<?php

namespace App\Jobs;

use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SyncStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param Student $student
     * @return void
     */
    public function handle(Student $student)
    {
        foreach ($this->data as $api) {
            Log::info('Processing '.$api->forename);
            try {
                $student->updateOrCreate(['mis_id' => $api->mis_id],
                    [
                        'id' => $api->id,
                        'mis_id' => $api->mis_id,
                        'admission_number' => $api->admission_number,
                        'upn' => $api->upn,
                        'forename' => $api->forename,
                        'surname' => $api->surname,
                        'year_group' => $api->year_group,
                        'birth_date' => $api->birth_date,
                        'ever_in_care' => $api->ever_in_care,
                        'sen_category' => $api->sen_category,
                ]);
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }
        Log::info('Students stored in database');
        dispatch(new SyncSiblingsAndPhotos());
    }
}

<?php

namespace App\Jobs;

use App\Repositories\Assembly;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GetStudentsFromSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $response = (new Assembly())->getStudents();

        $students = json_decode($response);

        foreach ($students->data as $student) {
            $this->data[$student->id] = [
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
            ];
        }
        Log::info('Students retrieved from API');
        $sync = json_decode(json_encode($this->data), FALSE);
        dispatch(new SyncStudents($sync));
    }
}

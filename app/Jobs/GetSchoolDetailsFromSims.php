<?php

namespace App\Jobs;

use App\Repositories\Assembly;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GetSchoolDetailsFromSims implements ShouldQueue
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
        $response = (new Assembly())->getSchoolDetails();

        $school = json_decode($response);

        $this->data[$school->urn] = [
            'urn' => $school->urn,
            'name' => $school->name,
            'headteacher' => $school->head_teacher,
            'la_name' => $school->la_name,
            'street' => $school->street,
            'town' => $school->town,
            'postcode' => $school->postcode,
        ];

        Log::info('School details retrieved from API');
        $sync = json_decode(json_encode($this->data), FALSE);
        dispatch(new SyncSchoolDetails($sync));
    }
}

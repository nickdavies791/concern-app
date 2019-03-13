<?php

namespace App\Jobs;

use App\School;
use Illuminate\Bus\Queueable;
use App\Repositories\Assembly;
use App\Jobs\SyncSchoolDetails;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetSchoolDetailsFromSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(School $school)
    {
        $response = json_decode((new Assembly())->getSchoolDetails());

        //For debugging
        info('Processing school details...', ['Data: ' => $response]);

        try {
            $school->updateOrCreate(['urn' => $response->urn], [
                'urn' => $response->urn,
                'name' => $response->name,
                'headteacher' => $response->head_teacher,
                'la_name' => $response->la_name,
                'street' => $response->street,
                'town' => $response->town,
                'postcode' => $response->postcode
            ]);
        } catch (\Exception $e) {
            info('Error adding school details', ['Error: ' => $e]);
        }

        info('School details saved.');
    }
}

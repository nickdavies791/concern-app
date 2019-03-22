<?php

namespace App\Jobs;

use App\School;
use Illuminate\Bus\Queueable;
use App\Repositories\Assembly;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetSchoolDetailsFromSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(School $school, Assembly $assembly)
    {
        $schoolData = $assembly->getSchoolDetails();

        try {
            $school->updateOrCreate(['urn' => $schoolData->urn], [
                'urn' => $schoolData->urn,
                'name' => $schoolData->name,
                'headteacher' => $schoolData->head_teacher,
                'la_name' => $schoolData->la_name,
                'street' => $schoolData->street,
                'town' => $schoolData->town,
                'postcode' => $schoolData->postcode
            ]);
        } catch (\Exception $e) {
            info('Error adding school details', ['Error: ' => $e]);
        }
    }
}

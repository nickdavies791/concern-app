<?php

namespace App\Jobs;

use App\School;
use App\Services\Interfaces\MISInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetSchoolDetails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param MISInterface $mis
     * @param School $school
     * @return void
     */
    public function handle(MISInterface $mis, School $school)
    {
        $schoolData = $mis->getSchoolDetails();

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

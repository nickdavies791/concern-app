<?php

namespace App\Jobs;

use App\Exclusion;
use App\Repositories\Assembly;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetExclusionsFromSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(Assembly $assembly, Exclusion $exclusion)
    {
        foreach ( $assembly->getExclusions() as $exclusionData) {
            try {
                $exclusion->updateOrCreate(['student_id' => $exclusionData->student_id], [
                    'id' => $exclusionData->id,
                    'student_id' => $exclusionData->student_id,
                    'type' => $exclusionData->type,
                    'reason' => $exclusionData->reason,
                    'start_date' => $exclusionData->start_date,
                    'start_session' => $exclusionData->start_session,
                    'end_date' => $exclusionData->end_date,
                    'end_session' => $exclusionData->end_session,
                    'length' => $exclusionData->length,
                ]);
            } catch (\Exception $e) {
                info('Error: ', ['Error: ' => $e]);
            }
        }
    }
}

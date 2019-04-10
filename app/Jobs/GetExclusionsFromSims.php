<?php

namespace App\Jobs;

use App\Exclusion;
use App\Services\Interfaces\MISInterface;
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
     * @param MISInterface $mis
     * @param Exclusion $exclusion
     * @return void
     */
    public function handle(MISInterface $mis, Exclusion $exclusion)
    {
        foreach ( $mis->getExclusions() as $exclusionData) {
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

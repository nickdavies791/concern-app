<?php

namespace App\Jobs;

use App\Repositories\Assembly;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GetExclusionsFromSims implements ShouldQueue
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
        $response = (new Assembly())->getExclusions();

        $exclusions = json_decode($response);

        foreach ($exclusions->data as $exclusion) {
            $this->data[$exclusion->id] = [
                'id' => $exclusion->id,
                'student_id' => $exclusion->student_id,
                'type' => $exclusion->exclusion_type,
                'reason' => $exclusion->exclusion_reason,
                'start_date' => $exclusion->start_date,
                'start_session' => $exclusion->start_session,
                'end_date' => $exclusion->end_date,
                'end_session' => $exclusion->end_session,
                'length' => $exclusion->exclusion_length,
            ];
        }
        Log::info('Exclusions retrieved from API');
        $sync = json_decode(json_encode($this->data), FALSE);
        dispatch(new SyncExclusions($sync));
    }
}

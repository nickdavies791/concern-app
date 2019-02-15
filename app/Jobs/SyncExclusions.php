<?php

namespace App\Jobs;

use App\Exclusion;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SyncExclusions implements ShouldQueue
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
     * @param Exclusion $exclusion
     * @return void
     */
    public function handle(Exclusion $exclusion)
    {
        Log::info('Processing exclusions...');
        foreach ($this->data as $api) {
            try {
                $exclusion->updateOrCreate(['student_id' => $api->student_id], [
                    'id' => $api->id,
                    'student_id' => $api->student_id,
                    'type' => $api->type,
                    'reason' => $api->reason,
                    'start_date' => $api->start_date,
                    'start_session' => $api->start_session,
                    'end_date' => $api->end_date,
                    'end_session' => $api->end_session,
                    'length' => $api->length,
                ]);
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }
        Log::info('Exclusions saved.');
    }
}

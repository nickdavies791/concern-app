<?php

namespace App\Jobs;

use App\School;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SyncSchoolDetails implements ShouldQueue
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
     * @param School $school
     * @return void
     */
    public function handle(School $school)
    {
        Log::info('Processing school details...', ['Data: ' => $this->data]);

        foreach ($this->data as $api) {
            try {
                $school->updateOrCreate(['urn' => $api->urn], [
                    'urn' => $api->urn,
                    'name' => $api->name,
                    'headteacher' => $api->headteacher,
                    'la_name' => $api->la_name,
                    'street' => $api->street,
                    'town' => $api->town,
                    'postcode' => $api->postcode
                ]);
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }

        Log::info('School details saved.');
    }
}

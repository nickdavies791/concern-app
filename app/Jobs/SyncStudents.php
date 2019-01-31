<?php

namespace App\Jobs;

use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SyncStudents implements ShouldQueue
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
     * @param Student $student
     * @return void
     */
    public function handle(Student $student)
    {
        foreach ($this->data as $api) {
            try {
                $student->updateOrCreate(['mis_id' => $api->mis_id],
                    [
                        'mis_id' => $api->mis_id,
                        'admission_number' => $api->admission_number,
                        'upn' => $api->upn,
                        'forename' => $api->forename,
                        'surname' => $api->surname,
                        'year_group' => $api->year_group,
                        'birth_date' => $api->birth_date,
                        'ever_in_care' => $api->ever_in_care,
                        'sen_category' => $api->sen_category,
                ]);
                // Get the student from the database
                $database = $student->whereMisId($api->mis_id)->first();
                // Get the hash from the API
                $hash = $api->photo->hash ?? null;
                // If the hash from the API is not null
                if (!$hash == null) {
                    // If current hash is different or null
                    if ($database->photo_hash !== $hash || $database->photo_hash == null) {
                        // Save image
                        $image = $api->photo->url;
                        $contents = file_get_contents($image);
                        Storage::disk('students')->put($api->mis_id.'.jpg', $contents);
                        // Update the hash in the database
                        $student->where('mis_id', $api->mis_id)->update(['photo_hash' => $api->photo->hash]);
                    }
                }
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }
    }
}

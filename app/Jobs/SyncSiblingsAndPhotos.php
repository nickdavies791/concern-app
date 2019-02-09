<?php

namespace App\Jobs;

use App\Repositories\Assembly;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SyncSiblingsAndPhotos implements ShouldQueue
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
        $response = (new Assembly())->getStudents();

        $students = json_decode($response);

        foreach ($students->data as $student) {
            $this->data[$student->id] = [
                'id' => $student->id,
                'mis_id' => $student->mis_id,
                'siblings' => $student->siblings,
                'photo' => $student->photo
            ];
            $api = json_decode(json_encode($this->data), FALSE);
        }

        Log::info('Saving siblings and photos...');
        foreach ($api as $record) {
            // Get the student from the database
            $database = Student::where('mis_id', $record->mis_id)->first();
            $siblings = $record->siblings ?? null;
            // If student has siblings
            if (!$siblings == null) {
                foreach ($siblings as $sibling) {
                    // Store each sibling in pivot table
                    $database->siblings()->syncWithoutDetaching($sibling);
                }
            }
            Log::info('Siblings saved.');
            // Get the photo hash from the API
            $hash = $record->photo->hash ?? null;
            // If the student has a photo
            if (!$hash == null) {
                Log::info('Saving photos...');
                // If current hash is different or null
                if ($database->photo_hash !== $hash || $database->photo_hash == null) {
                    // Save image
                    $image = $record->photo->url;
                    $contents = file_get_contents($image);
                    Storage::disk('students')->put($record->mis_id.'.jpg', $contents);
                    // Update the hash in the database
                    Student::where('mis_id', $record->mis_id)->update(['photo_hash' => $record->photo->hash]);
                }
            }
        }
        Log::info('Siblings and photos saved.');
    }
}

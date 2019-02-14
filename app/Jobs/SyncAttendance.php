<?php

namespace App\Jobs;

use App\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SyncAttendance implements ShouldQueue
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
     * @param Attendance $attendance
     * @return void
     */
    public function handle(Attendance $attendance)
    {
        Log::info('Processing attendance...');
        foreach ($this->data as $api) {
            try {
                $attendance->updateOrCreate(['student_id' => $api->student_id], [
                    'id' => $api->id,
                    'student_id' => $api->student_id,
                    'start_date' => $api->start_date,
                    'end_date' => $api->end_date,
                    'possible_sessions' => $api->possible_sessions,
                    'attended_sessions' => $api->attended_sessions,
                    'late_sessions' => $api->late_sessions,
                    'authorised_absence_sessions' => $api->authorised_absence_sessions,
                    'unauthorised_absence_sessions' => $api->unauthorised_absence_sessions,
                ]);
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }
        Log::info('Attendance saved.');
    }
}

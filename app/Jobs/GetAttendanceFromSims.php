<?php

namespace App\Jobs;

use App\Repositories\Assembly;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GetAttendanceFromSims implements ShouldQueue
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
     */
    public function handle()
    {
        $response = (new Assembly())->getAttendance();

        $attendances = json_decode($response);

        foreach ($attendances->data as $attendance) {
            $this->data[$attendance->id] = [
                'id' => $attendance->id,
                'student_id' => $attendance->student_id,
                'start_date' => $attendance->start_date,
                'end_date' => $attendance->end_date,
                'possible_sessions' => $attendance->possible_sessions,
                'attended_sessions' => $attendance->attended_sessions,
                'late_sessions' => $attendance->late_sessions,
                'authorised_absence_sessions' => $attendance->authorised_absence_sessions,
                'unauthorised_absence_sessions' => $attendance->unauthorised_absence_sessions,
            ];
        }
        Log::info('Attendance retrieved from API');
        $sync = json_decode(json_encode($this->data), FALSE);
        dispatch(new SyncAttendance($sync));
    }
}

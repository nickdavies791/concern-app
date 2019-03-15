<?php

namespace App\Jobs;

use App\Attendance;
use Illuminate\Bus\Queueable;
use App\Repositories\Assembly;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetAttendanceData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
    * Formats attendance data and syncs it with database data.
    *
    * @return void
    * @throws \GuzzleHttp\Exception\GuzzleException
    */
    public function handle(Attendance $attendance, Assembly $assembly)
    {
        foreach ( $assembly->getAttendance() as $data) {
            try {
                $attendance->updateOrCreate(
                    ['student_id' => $data->student_id],
                    [
                        'id' => $data->id,
                        'student_id' => $data->student_id,
                        'start_date' => $data->start_date,
                        'end_date' => $data->end_date,
                        'possible_sessions' => $data->possible_sessions,
                        'attended_sessions' => $data->attended_sessions,
                        'late_sessions' => $data->late_sessions,
                        'authorised_absence_sessions' => $data->authorised_absence_sessions,
                        'unauthorised_absence_sessions' => $data->unauthorised_absence_sessions,
                    ]
                );
            } catch (\Exception $e) {
                info('Error: ', ['Error: ' => $e]);
            }
        }
    }
}

<?php

namespace App\Console;

use App\Jobs\GetAttendanceFromSims;
use App\Jobs\GetExclusionsFromSims;
use App\Jobs\GetStaffMembersFromSims;
use App\Jobs\GetStudentsFromSims;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule Students Sync
        $schedule->job(new GetStudentsFromSims())->weeklyOn(1, '6:00');
        // Schedule Attendance Sync
        $schedule->job(new GetAttendanceFromSims())->dailyAt('6:00');
        // Schedule Exclusions Sync
        $schedule->job(new GetExclusionsFromSims())->dailyAt('6:00');
        // Schedule Staff Sync
        $schedule->job(new GetStaffMembersFromSims())->weeklyOn(1, '6:00');
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
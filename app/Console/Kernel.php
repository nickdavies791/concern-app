<?php

namespace App\Console;

use App\Jobs\GetAttendance;
use App\Jobs\GetExclusions;
use App\Jobs\GetStaffMembers;
use App\Jobs\GetStudents;
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
        $schedule->job(new GetStudents())->weeklyOn(1, '6:00');
        // Schedule Attendance Sync
        $schedule->job(new GetAttendance())->dailyAt('6:00');
        // Schedule Exclusions Sync
        $schedule->job(new GetExclusions())->dailyAt('6:00');
        // Schedule Staff Sync
        $schedule->job(new GetStaffMembers())->weeklyOn(1, '6:00');
        // Prune Telescope data older than 24 hours
        $schedule->command('telescope:prune')->daily();
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
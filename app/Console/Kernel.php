<?php

namespace App\Console;

use App\Jobs\GetStaffMembersFromSims;
use App\User;
use App\Student;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;

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
        $schedule->call(function () {
            Log::info('Task scheduler: Fetching students');
            $this->dispatch(new GetStudentsFromSims());
        })->everyTenMinutes()->runInBackground();
        // Schedule Staff Sync
        $schedule->call(function () {
            Log::info('Task scheduler: Fetching Staff');
            $this->dispatch(new GetStaffMembersFromSims());
        })->everyTenMinutes()->runInBackground();
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

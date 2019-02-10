<?php

namespace App\Console;

use App\Jobs\GetStaffMembersFromSims;
use App\Jobs\GetStudentsFromSims;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        Log::info('Task scheduler: Fetching students');
        $schedule->job(new GetStudentsFromSims())->everyMinute();
        // Schedule Staff Sync
        Log::info('Task scheduler: Fetching Staff');
        $schedule->job(new GetStaffMembersFromSims())->everyMinute();
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

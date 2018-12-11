<?php

namespace App\Console;

use App\User;
use App\Student;
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
        //sync database with SIMS API
        $schedule->call(function () {
            (new Student)->updateStudentRecords();
            info(['Database synced' => 'Student records updated']);
        })->monthly()->runInBackground();

        $schedule->call(function () {
            (new User)->updateStaffRecords();
            info(['Database synced' => 'Staff records updated']);
        })->monthly()->runInBackground();
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

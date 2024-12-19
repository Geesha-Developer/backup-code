<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Define scheduled commands here
        // Example: $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Load commands from the 'Commands' directory
        $this->load(__DIR__.'/Commands');

        // Load additional commands defined in 'routes/console.php'
        require base_path('routes/console.php');
    }
    protected $commands = [
        \App\Console\Commands\CheckLogs::class,
    ];
    
}

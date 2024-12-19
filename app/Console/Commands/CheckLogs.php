<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the latest log entries';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            $logs = File::get($logFile);
            $this->info($logs);
        } else {
            $this->error('Log file does not exist.');
        }
    }
}

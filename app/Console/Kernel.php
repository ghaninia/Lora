<?php

namespace App\Console;

use App\Console\Commands\DiscountStatus;
use App\Console\Commands\Fresh;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Fresh::class ,
        DiscountStatus::class
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('discount:status')
                  ->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

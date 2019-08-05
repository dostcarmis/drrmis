<?php

namespace App\Console;

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
        'App\Console\Commands\LogDemo',
        'App\Console\Commands\CheckNotification',
        'App\Console\Commands\RunMiner',
        'App\Console\Commands\Checkfloodnotification',
        'App\Console\Commands\GenerateKml',
        'App\Console\Commands\Generatehydrometdata',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
     
        $schedule->command('generate:hydromet')->everyFiveMinutes();
        
    }
}

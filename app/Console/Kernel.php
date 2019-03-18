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
        $schedule->command('notifier:MobileBG ' . env('APP_URL'))->cron('*/6 * * * *');
        $schedule->command('notifier:MobileBGBikes ' . env('APP_URL'))->cron('*/6 * * * *');
        $schedule->command('notifier:MobileBGBuses ' . env('APP_URL'))->cron('*/6 * * * *');
        $schedule->command('notifier:CarsBG')->cron('1,16,31,46 * * * *');
        $schedule->command('notifier:CarsBGBuses')->cron('1,16,31,46 * * * *');
        $schedule->command('notifier:clearCars')->cron('*/30 * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use App\Console\Commands\SnoozeReminder;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SendReminderNotifications;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

        SendReminderNotifications::class,
        // SnoozeReminder::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('jogging:reminder')->everyMinute()->appendOutputTo(storage_path() . '/logs/laravel.log');
        // $schedule->command('snooze:reminder')->everyMinute()->appendOutputTo(storage_path() . '/logs/laravel.log');
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

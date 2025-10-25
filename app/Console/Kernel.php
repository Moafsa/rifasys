<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // System health check every 5 minutes
        $schedule->command('system:health-check --silent')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground();

        // System health check with alerts every 15 minutes
        $schedule->command('system:health-check --email=admin@rafe.com --threshold=degraded')
            ->everyFifteenMinutes()
            ->withoutOverlapping();

        // Cache cleanup every hour
        $schedule->command('cache:clear')
            ->hourly()
            ->withoutOverlapping();

        // Optimize database every 6 hours
        $schedule->command('db:optimize')
            ->everySixHours()
            ->withoutOverlapping();

        // Clear old logs daily
        $schedule->command('log:clear')
            ->daily()
            ->at('02:00')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

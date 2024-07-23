<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendDailyPostsReport::class,
        \App\Console\Commands\DeleteOldPasswordResets::class,
        \App\Console\Commands\SendFridayEmail::class,
        \App\Console\Commands\SendMonthlyDashboardData::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('email:friday')->timezone("Asia/Rangoon")->fridays()->at('08:00')->before(function () {
            Log::info('Starting Friday email task');
        })->after(function () {
            Log::info('Finished Friday email task');
        });

        $schedule->command('passwordresets:delete-old')->timezone("Asia/Rangoon")->daily()->at('08:48')->before(function () {
            Log::info('Starting password reset cleanup task');
        })->after(function () {
            Log::info('Finished password reset cleanup task');
        });

        $schedule->command('email:monthly-dashboard')->timezone("Asia/Rangoon")->lastDayOfMonth('08:00')->before(function () {
            Log::info('Starting monthly dashboard email task');
        })->after(function () {
            Log::info('Finished monthly dashboard email task');
        });

        $schedule->command('send:daily-posts-report')->timezone("Asia/Rangoon")->dailyAt('08:00')->before(function () {
            Log::info('Starting sending latest ten active post in daily to admin');
        })->after(function () {
            Log::info('Finished sending latest ten active post in daily to admin');
        });

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

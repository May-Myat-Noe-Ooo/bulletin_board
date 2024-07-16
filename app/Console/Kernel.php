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
        // $schedule->command('inspire')->hourly();
        $schedule->command('email:friday')->fridays()->at('08:00')->before(function () {
            \Log::info('Starting Friday email task');
        })->after(function () {
            \Log::info('Finished Friday email task');
        });

        $schedule->command('passwordresets:delete-old')->daily()->before(function () {
            \Log::info('Starting password reset cleanup task');
        })->after(function () {
            \Log::info('Finished password reset cleanup task');
        });

        $schedule->command('email:monthly-dashboard')->lastDayOfMonth('08:00')->before(function () {
            \Log::info('Starting monthly dashboard email task');
        })->after(function () {
            \Log::info('Finished monthly dashboard email task');
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

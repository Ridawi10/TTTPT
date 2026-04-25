<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\App;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:sync-api1')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api2')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api3')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api4')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api5')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api6')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api7')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api8')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api9')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:sync-api10')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('app:system-configs')->daily()->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

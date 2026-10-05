<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\RollupVisitorStats::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Rollup visitor stats setiap hari jam 01:00 (P-05)
        $schedule->command('stats:rollup-visitors')
            ->dailyAt('01:00')
            ->timezone('Asia/Jakarta')
            ->description('Daily rollup of visitor statistics');

        // Tangani edge case jika ada yang gagal kemarin
        $schedule->command('stats:rollup-visitors --date=' . now()->subDay()->toDateString())
            ->dailyAt('01:15')
            ->timezone('Asia/Jakarta')
            ->runInBackground()
            ->withoutOverlapping(5);
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}

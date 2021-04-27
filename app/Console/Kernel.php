<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Currency\Console\CurrencyParseCommand;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CurrencyParseCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(CurrencyParseCommand::class)
            ->twiceDaily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

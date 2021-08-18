<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Currency\Console\CurrencyParseCommand;
use Modules\Export\Services\ExportScheduler;

class Kernel extends ConsoleKernel
{
    public function __construct(
        Application $app,
        Dispatcher $events
    )
    {
        parent::__construct($app, $events);
    }

    protected $commands = [
        CurrencyParseCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(CurrencyParseCommand::class)
            ->twiceDaily();

        app(ExportScheduler::class)
            ->scheduleExportCommands($schedule);
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

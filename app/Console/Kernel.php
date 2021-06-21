<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Currency\Console\CurrencyParseCommand;
use Modules\Export\Console\GenerateFacebookMarket;
use Modules\Export\Console\GenerateGoogleMarket;
use Modules\Export\Console\GenerateTiuMarket;
use Modules\Export\Console\GenerateYandexMarket;

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
        GenerateFacebookMarket::class,
        GenerateGoogleMarket::class,
        GenerateTiuMarket::class,
        GenerateYandexMarket::class,
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

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Currency\Console\CurrencyParseCommand;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Models\Export;
use Modules\Export\Services\ExportService;

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

        foreach (Export::query()->get() as $export) {
            $command = (new ExportService)->determine($export);

            $frequency = ExportFrequency::getFrequency($export->frequency);

            if ($frequency !== ExportFrequency::MANUALLY) {
                $schedule = $schedule->command($command, array_merge($export->parameters, [
                    'filename' => $export->filename,
                ]))
                    ->$frequency();
            }
        }
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

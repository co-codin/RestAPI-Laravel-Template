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
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Repositories\ExportRepository;
use Modules\Export\Services\ExportService;

class Kernel extends ConsoleKernel
{
    public function __construct(
        Application $app,
        Dispatcher $events,
        protected ExportRepository $exportRepository,
        protected ExportService $exportService
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

        foreach ($this->exportRepository->get() as $export) {
            $command = $this->exportService->determine($export);

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

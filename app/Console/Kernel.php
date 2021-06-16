<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Modules\Currency\Console\CurrencyParseCommand;
use Modules\Export\Enum\ExportType;
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
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(CurrencyParseCommand::class)
            ->twiceDaily();

        foreach ($this->exportRepository->get() as $export) {
            $command = $this->exportService->determine($export);

            Artisan::call($command, $export->parameters);
        }
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

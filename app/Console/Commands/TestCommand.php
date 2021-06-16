<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Repositories\ExportRepository;
use Modules\Export\Services\ExportService;

class TestCommand extends Command
{
    protected $signature = 'test:command';

    public function __construct(
        protected ExportRepository $exportRepository,
        protected ExportService $exportService
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        foreach ($this->exportRepository->get() as $export) {
            $command = $this->exportService->determine($export);

            $frequency = ExportFrequency::getFrequency($export->frequency);

            if ($frequency !== ExportFrequency::MANUALLY) {
                $schedule = $schedule->command($command, $export->parameters)
                    ->$frequency();
            }
        }
    }
}

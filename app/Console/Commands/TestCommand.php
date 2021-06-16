<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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

            Artisan::call($command, $export->parameters);
        }
    }
}

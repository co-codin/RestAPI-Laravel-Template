<?php


namespace Modules\Export\Console;


use Illuminate\Console\Command;
use Modules\Export\Models\Export;
use Modules\Export\Services\ExportService;

class ExportFeedCommand extends Command
{
    protected $signature = 'export:generate-feed {export_id}';

    protected $description = 'Export feed';

    public function handle(ExportService $exportService): void
    {
        $export = Export::query()->findOrFail($this->argument('export_id'));

        $exportService->getGenerator($export)->generate($export);
    }
}

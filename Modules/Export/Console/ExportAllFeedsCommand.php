<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;
use Modules\Export\Enum\ExportType;
use Modules\Export\Services\ExportScheduler;

class ExportAllFeedsCommand extends Command
{
    protected $signature = 'export:generate-all-feeds';

    protected $description = 'Export all feed';

    public function handle(ExportScheduler $exportScheduler): void
    {
        foreach ($exportScheduler->getAllScheduledExports() as $export) {
            $this->info("Экспорт товаров для " . ExportType::getDescription($export->type));
            $this->call(ExportFeedCommand::class, ['export_id' => $export->id]);
        }
    }
}

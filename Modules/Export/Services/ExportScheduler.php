<?php

namespace Modules\Export\Services;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Modules\Export\Console\ExportFeedCommand;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Models\Export;

class ExportScheduler
{
    public function scheduleExportCommands(Schedule $schedule): void
    {
        foreach ($this->getAllScheduledExports() as $export) {
            $frequency = ExportFrequency::getFrequency($export->frequency);
            $schedule->command(ExportFeedCommand::class, [$export->id])->{$frequency}();
        }
    }

    protected function getAllScheduledExports(): Collection
    {
        return Export::query()
            ->where('frequency', '!=', ExportFrequency::MANUALLY)
            ->get();
    }
}

<?php

namespace Modules\Export\Services;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Export\Models\Export;

class ExportScheduler
{
    public function scheduleExportCommands(Schedule $schedule)
    {
        foreach ($this->getAllScheduledExports() as $export) {
            $command = ExportType::getCommand($export->type);
            $frequency = ExportFrequency::getFrequency($export->frequency);
            $parameters = array_merge($export->parameters, [
                'filename' => $export->filename,
            ]);

            $schedule->command($command, $parameters)->{$frequency}();
        }
    }

    protected function getAllScheduledExports(): Collection
    {
        return Export::query()
            ->where('frequency', '!=', ExportFrequency::MANUALLY)
            ->get();
    }
}

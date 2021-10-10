<?php

namespace Modules\Export\Services;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Export\Models\Export;

class ExportScheduler
{
    public function scheduleExportCommands(Schedule $schedule): void
    {
        $scheduleExports = $this->getAllScheduledExports();

        foreach ($scheduleExports as $export) {
            $command = ExportType::getCommand($export->type);
            $frequency = ExportFrequency::getFrequency($export->frequency);
            $parameters = array_merge(
                $export->parameters,
                ['filename' => $export->filename]
            );

            $schedule->command($command, $parameters)->{$frequency}();
            $export->update([
                'exported_at' => Carbon::now()->toDateTimeString()
            ]);
        }
    }

    /**
     * @return Export[]|Collection
     */
    protected function getAllScheduledExports(): Collection
    {
        return Export::query()
            ->where('frequency', '!=', ExportFrequency::MANUALLY)
            ->get();
    }
}

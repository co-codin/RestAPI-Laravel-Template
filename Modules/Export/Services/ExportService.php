<?php

namespace Modules\Export\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Modules\Export\Enum\ExportType;
use Modules\Export\Models\Export;


class ExportService
{
    public function determine(Export $export): string
    {
        return ExportType::getCommand($export->type);
    }

    public function call(Export $export): void
    {
        $command = $this->determine($export);

        Artisan::call($command, [
            'parameters' => array_merge($export->parameters, [
                'filename' => $export->filename,
            ])
        ]);

        $export->update([
            'exported_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}

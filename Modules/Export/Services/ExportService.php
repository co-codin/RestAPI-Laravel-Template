<?php


namespace Modules\Export\Services;


use Modules\Export\Enum\ExportType;
use Modules\Export\Models\Export;

class ExportService
{
    public function determine(Export $export)
    {
        return ExportType::getCommand($export->type);
    }
}

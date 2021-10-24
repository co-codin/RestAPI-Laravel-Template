<?php

namespace Modules\Export\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Export\Enum\ExportType;
use Modules\Export\Models\Export;
use Modules\Export\Services\Generators\FeedGeneratorInterface;

class ExportService
{
    public function getGenerator(Export|Model $export): FeedGeneratorInterface
    {
        return app(ExportType::$generators[$export->type]);
    }
}

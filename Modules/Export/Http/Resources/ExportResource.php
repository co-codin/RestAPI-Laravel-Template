<?php


namespace Modules\Export\Http\Resources;


use App\Http\Resources\BaseJsonResource;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Export\Models\Export;


/**
 * Class ExportResource
 * @package Modules\Export\Http\Resources
 * @mixin Export
 */
class ExportResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'type' => $this->whenRequested('type', fn() => ExportType::fromValue($this->type)->toArray()),
            'frequency' => $this->whenRequested('frequency', fn() => ExportFrequency::fromValue($this->frequency)->toArray()),
        ]);
    }
}

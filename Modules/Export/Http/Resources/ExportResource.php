<?php


namespace Modules\Export\Http\Resources;


use App\Http\Resources\BaseJsonResource;
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
        return parent::toArray($request);
    }
}

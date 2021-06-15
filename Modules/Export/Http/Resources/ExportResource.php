<?php


namespace Modules\Export\Http\Resources;


use App\Http\Resources\BaseJsonResource;

class ExportResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

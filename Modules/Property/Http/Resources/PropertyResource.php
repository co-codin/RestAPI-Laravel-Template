<?php


namespace Modules\Property\Http\Resources;


use App\Transformers\BaseJsonResource;

class PropertyResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

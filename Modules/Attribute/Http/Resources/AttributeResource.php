<?php


namespace Modules\Attribute\Http\Resources;


use App\Http\Resources\BaseJsonResource;

class AttributeResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

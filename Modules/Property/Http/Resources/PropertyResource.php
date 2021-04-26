<?php


namespace Modules\Property\Http\Resources;


use App\Transformers\BaseJsonResource;
use Modules\Property\Enums\PropertyType;
use Modules\Property\Models\Property;

/**
 * Class PropertyResource
 * @package Modules\Property\Http\Resources
 * @mixin Property
 */
class PropertyResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'type' => $this->whenRequested('type', PropertyType::toJson($this->type)),
        ]);
    }
}

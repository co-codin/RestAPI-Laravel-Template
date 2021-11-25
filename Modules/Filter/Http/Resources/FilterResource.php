<?php


namespace Modules\Filter\Http\Resources;


use App\Http\Resources\BaseJsonResource;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Filter\Enums\FilterType;
use Modules\Filter\Models\Filter;
use Modules\Property\Http\Resources\PropertyResource;

/**
 * Class FilterResource
 * @package Modules\Filter\Http\Resources
 * @mixin Filter
 */
class FilterResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'category' => new CategoryResource($this->whenLoaded('category')),
            'property' => new PropertyResource($this->whenLoaded('property')),
        ]);
    }
}

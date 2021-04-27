<?php

namespace Modules\Category\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Category\Models\Category;
use Modules\Seo\Http\Resources\SeoResource;

/**
 * Class CategoryResource
 * @package Modules\Category\Http\Resources
 * @mixin Category
 */
class CategoryResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'parent' => new CategoryResource($this->whenLoaded('parent')),
            'ancestors' => CategoryResource::collection($this->whenLoaded('ancestors')),
            'descendants' => CategoryResource::collection($this->whenLoaded('descendants')),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'is_main' => $this->whenPivotLoaded('product_category', function () {
                return $this->pivot->is_main;
            }),
        ]);
    }
}

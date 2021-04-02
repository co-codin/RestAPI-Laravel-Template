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
            'seo' => $this->whenLoaded('seo', fn() => new SeoResource($this->seo)),
            'parent' => $this->whenLoaded('parent', fn() => new CategoryResource($this->parent)),
            'ancestors' => $this->whenLoaded('ancestors', fn() => CategoryResource::collection($this->ancestors)),
            'descendants' => $this->whenLoaded('descendants', fn() => CategoryResource::collection($this->descendants)),
        ]);
    }
}

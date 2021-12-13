<?php

namespace Modules\Cabinet\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Seo\Http\Resources\SeoResource;

class CabinetResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', fn() => Status::fromValue($this->status)->toArray()),
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ]);
    }
}

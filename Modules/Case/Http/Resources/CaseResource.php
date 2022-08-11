<?php

namespace Modules\Case\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Seo\Http\Resources\SeoResource;

class CaseResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', fn() => Status::fromValue($this->status)->toArray()),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}

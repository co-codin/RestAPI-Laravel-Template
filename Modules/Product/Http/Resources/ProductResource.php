<?php


namespace Modules\Product\Http\Resources;


use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Brand\Http\Resources\BrandResource;
use Modules\Seo\Http\Resources\SeoResource;

class ProductResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
        ]);
    }
}

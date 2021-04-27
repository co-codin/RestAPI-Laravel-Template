<?php


namespace Modules\Product\Http\Resources;


use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Brand\Http\Resources\BrandResource;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Property\Http\Resources\PropertyResource;
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
            'properties' => PropertyResource::collection($this->whenLoaded('properties')),
            'productVariants' => ProductVariantResource::collection($this->whenLoaded('productVariants')),
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ]);
    }
}

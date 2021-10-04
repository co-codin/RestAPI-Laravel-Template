<?php

namespace Modules\Product\Http\Resources\Index;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;
use Modules\Property\Models\Property;

/**
 * Class ProductSearchResource
 * @package Modules\Search\Services\Indices
 * @mixin Product
 */
class ProductSearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => [
                'id' => $this->status,
                'name' => Status::getDescription($this->status),
                'slug' => Str::slug(Status::getDescription($this->status)),
            ],
            'warranty' => $this->warranty,
            'brand' => new ProductBrandSearchResource($this->brand),
            'category' => new ProductCategorySearchResource($this->category),
            'categories' => ProductCategorySearchResource::collection($this->categories),
            'properties' => ProductPropertySearchResource::collection($this->properties),
            'variations' => ProductVariationSearchResource::collection($this->productVariations),
            'facets' => array_merge($this->systemFacets(), $this->propertyFacets()),
        ];
    }

    protected function systemFacets(): array
    {
        return [
            ['name' => 'status', 'value' => $this->status],
            ['name' => 'brand', 'value' => $this->brand_id],
            ['name' => 'brand.country', 'value' => $this->brand->country],
            ['name' => 'category', 'value' => $this->category->id],
            ['name' => 'categories', 'value' => $this->categories->pluck('id')->toArray()],
        ];
    }

    protected function propertyFacets(): array
    {
        return $this->properties->map(function(Property $property) {
                return [
                    'name' => $property->name,
                    'key' => 'properties.' . $property->key,
                    'value' => $property->pivot->value,
                ];
            })
            ->toArray();
    }
}

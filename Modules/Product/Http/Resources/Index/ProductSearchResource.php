<?php

namespace Modules\Product\Http\Resources\Index;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;

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
            'properties' => ProductPropertySearchResource::collection($this->properties),
        ];
    }
}

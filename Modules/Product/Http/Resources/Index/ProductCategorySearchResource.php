<?php

namespace Modules\Product\Http\Resources\Index;


use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Category\Models\Category;

/**
 * Class ProductBrandSearchResource
 * @package Modules\Search\Services\Indices
 * @mixin Category
 */
class ProductCategorySearchResource extends JsonResource
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
        ];
    }
}

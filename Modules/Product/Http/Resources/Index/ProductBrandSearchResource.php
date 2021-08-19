<?php

namespace Modules\Product\Http\Resources\Index;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Brand\Models\Brand;

/**
 * Class ProductBrandSearchResource
 * @package Modules\Search\Services\Indices
 * @mixin Brand
 */
class ProductBrandSearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'country' => $this->country,
            'status' => [
                'id' => $this->status,
                'name' => Status::getDescription($this->status),
                'slug' => Str::slug(Status::getDescription($this->status)),
            ],
        ];
    }
}

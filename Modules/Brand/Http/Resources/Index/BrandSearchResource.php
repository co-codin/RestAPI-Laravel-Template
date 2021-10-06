<?php

namespace Modules\Brand\Http\Resources\Index;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Brand\Models\Brand;

/**
 * @mixin Brand
 */
class BrandSearchResource extends JsonResource
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
            'country' => $this->country,
        ];
    }
}

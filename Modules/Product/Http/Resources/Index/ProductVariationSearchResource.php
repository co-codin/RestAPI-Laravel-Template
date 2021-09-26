<?php

namespace Modules\Product\Http\Resources\Index;


use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Models\ProductVariation;

/**
 * Class ProductVariationSearchResource
 * @package Modules\Search\Services\Indices
 * @mixin ProductVariation
 */
class ProductVariationSearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'previous_price' => $this->previous_price,
            'is_enabled' => $this->is_enabled,
            'availability' => $this->availability,
            'is_price_visible' => $this->is_price_visible,
        ];
    }
}

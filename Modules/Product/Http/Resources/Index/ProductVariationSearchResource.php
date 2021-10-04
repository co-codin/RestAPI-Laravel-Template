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
            'facets' => [
                ['name' => 'is_enabled', 'value' => $this->is_enabled ? 1 : 0],
                ['name' => 'is_price_visible', 'value' => $this->is_price_visible ? 1 : 0],
                ['name' => 'stock_type', 'value' => $this->stock_type],
                ['name' => 'availability', 'value' => $this->availability],
                ['name' => 'is_hot', 'value' => !! $this->previous_price ? 1 : 0 ],
            ],
            'numeric_facets' => [
                ['name' => 'price', 'value' => $this->price],
            ],
        ];
    }
}

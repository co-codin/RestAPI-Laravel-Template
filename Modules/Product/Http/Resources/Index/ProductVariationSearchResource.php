<?php

namespace Modules\Product\Http\Resources\Index;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Modules\Product\Enums\Availability;
use Modules\Product\Enums\ProductVariationCondition;
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
                [
                    'name' => 'is_enabled',
                    'value' => $this->is_enabled ? 1 : 0,
                    'aggregation' => $this->is_enabled ? 1 : 0,
                ],
                [
                    'name' => 'is_price_visible',
                    'value' => $this->is_price_visible ? 1 : 0,
                    'aggregation' => $this->is_price_visible ? 1 : 0,
                ],
                [
                    'name' => 'stock_type',
                    'value' => $this->stock_type,
                    'aggregation' => $this->stock_type,
                ],
                [
                    'name' => 'availability',
                    'value' => $this->availability,
                    'aggregation' => $this->aggregation(
                        $this->availability,
                        Availability::getDescription($this->availability)
                    ),
                ],
                [
                    'name' => 'is_hot',
                    'value' => !! $this->previous_price ? 1 : 0,
                    'aggregation' => !! $this->previous_price ? 1 : 0,
                ],
                [
                    'name' => 'condition',
                    'value' => $this->condition,
                    'aggregation' => $this->aggregation(
                        $this->condition,
                        ProductVariationCondition::getDescription($this->condition)
                    ),
                ],
            ],
            'numeric_facets' => [
                ['name' => 'price', 'value' => $this->price],
            ],
        ];
    }

    protected function aggregation(string|array|null $key, string|array|null $value): array|null
    {
        if (!$key || !$value) {
            return null;
        }

        $key = Arr::wrap($key);
        $value = Arr::wrap($value);

        return collect($key)->map(fn($key, $index) => $key . "|||" . $value[$index])
            ->values()
            ->toArray();
    }
}

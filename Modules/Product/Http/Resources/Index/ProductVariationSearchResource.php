<?php

namespace Modules\Product\Http\Resources\Index;


use App\Models\FieldValue;
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
            'price_in_rub' => $this->price_in_rub,
            'is_enabled' => $this->is_enabled,
            'availability' => $this->availability,
            'is_price_visible' => $this->is_price_visible ? 1 : 2,
            'is_hot' => (!! $this->previous_price && $this->is_price_visible) ? 1 : 2,
            'availability_sort_value' => $this->isAvailableForSale() ? 1 : 2,
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
                    'name' => 'availability',
                    'value' => $this->availability,
                    'aggregation' => $this->aggregation(
                        $this->availability,
                        Availability::getDescription($this->availability)
                    ),
                ],
                [
                    'name' => 'is_hot',
                    'value' => (!! $this->previous_price && $this->is_price_visible) ? 1 : 0,
                    'aggregation' => !! $this->previous_price ? 1 : 0,
                ],
                [
                    'name' => 'condition',
                    'value' => $this->condition_id,
                    'aggregation' => $this->aggregation(
                        $this->condition_id,
                        $this->condition->value,
                    ),
                ],
            ],
            'numeric_facets' => [
                ['name' => 'price', 'value' => $this->price],
                ['name' => 'price_in_rub', 'value' => $this->price_in_rub],
            ],
        ];
    }

    protected function isAvailableForSale(): bool
    {
        return in_array($this->availability, [
            Availability::InStock,
            Availability::UnderTheOrder,
            Availability::ComingSoon,
        ]);
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

<?php

namespace Modules\Product\Http\Resources\Index;

use App\Enums\Status;
use App\Models\FieldValue;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
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
            'full_name' => "{$this->category->product_name} {$this->brand->name} $this->name",
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => [
                'id' => $this->status,
                'name' => Status::getDescription($this->status),
                'slug' => Str::slug(Status::getDescription($this->status)),
            ],
            'warranty' => $this->warranty,
            'group' => $this->group_id ?? 100, // TODO cant sort nulls last and for null set 100
            'brand' => new ProductBrandSearchResource($this->brand),
            'category' => new ProductCategorySearchResource($this->category),
            'categories' => ProductCategorySearchResource::collection($this->categories),
            'properties' => ProductPropertySearchResource::collection($this->properties),
            'variations' => ProductVariationSearchResource::collection($this->productVariations),
            'popular_score' => $this->getSearchScore(),
            'facets' => array_merge($this->systemFacets(), $this->propertyFacets()),
            'numeric_facets' => array_merge($this->numericPropertyFacets()),
        ];
    }

    protected function systemFacets(): array
    {
        $rootCategory = $this->category->ancestors->first();

        return [
            [
                'name' => 'status',
                'value' => $this->status,
                'aggregation' => $this->aggregation(
                    $this->status, Status::getDescription($this->status)
                ),
            ],
            [
                'name' => 'brand',
                'value' => $this->brand_id,
                'aggregation' => $this->aggregation(
                    $this->brand_id, $this->brand->name
                ),
            ],
            [
                'name' => 'root_category',
                'value' => $rootCategory ? $rootCategory->id : null,
                'aggregation' => $rootCategory ? $this->aggregation(
                    $rootCategory->id, $rootCategory->name
                ) : null,
            ],
            [
                'name' => 'brand.country',
                'value' => $this->brand->country_id,
                'aggregation' => $this->brand->country_id ? $this->aggregation(
                    $this->brand->country_id, $this->brand->country->value,
                ) : null,
            ],
            [
                'name' => 'category',
                'value' => $this->category->id,
                'aggregation' => $this->aggregation(
                    $this->category->id, $this->category->name,
                ),
            ],
            [
                'name' => 'categories',
                'value' => $this->categories->pluck('id')->toArray(),
                'aggregation' => $this->aggregation(
                    $this->categories->pluck('id')->toArray(),
                    $this->categories->pluck('name')->toArray(),
                ),
            ],
            [
                'name' => 'stock_type',
                'value' => $this->stock_type_id,
                'aggregation' => $this->stock_type_id ? $this->aggregation(
                    $this->stock_type_id,
                    $this->stockType->value,
                ): null,
            ],
        ];
    }

    protected function propertyFacets(): array
    {
        return $this->properties
            ->where('is_numeric', false)
            ->whereNotNull('pivot.field_value_ids')
            ->map(function(Property $property) {
                $fieldValues = FieldValue::query()
                    ->whereIn('id', Arr::wrap($property->pivot->field_value_ids))
                    ->pluck('value', 'id');
                return [
                    'name' => "properties." . $property->key,
                    'value' => $fieldValues->keys(),
                    'aggregation' => $this->aggregation($fieldValues->keys()->toArray(), $fieldValues->values()->toArray()),
                ];
            })
            ->toArray();
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

    protected function numericPropertyFacets(): array
    {
        return $this->properties
            ->where('is_numeric', true)
            ->whereNotNull('pivot.field_value_ids')
            ->map(function(Property $property) {
                $fieldValues = FieldValue::query()
                    ->whereIn('id', Arr::wrap($property->pivot->field_value_ids))
                    ->pluck('value', 'id')
                    ->filter(fn($value) => is_numeric($value));
                return [
                    'name' => "properties." . $property->key,
                    'value' => $fieldValues->values(),
                ];
            })
            ->toArray();
    }

    protected function getSearchScore()
    {
        $stockTypes = [
            "Лидер продаж" => 1,
            "Лучшая цена" => 2,
            "Медэк рекомендует" => 4,
        ];

        if($this->stockType) {
            return \Arr::get($stockTypes, $this->stockType->value, 5);
        }

        $hasHotVariation = $this->productVariations
            ->filter(function(ProductVariation $productVariation) {
                return !! $productVariation->previous_price && $productVariation->is_price_visible;
            })
            ->isNotEmpty();

        if ($hasHotVariation) {
            return 3;
        }

        return 6;
    }
}

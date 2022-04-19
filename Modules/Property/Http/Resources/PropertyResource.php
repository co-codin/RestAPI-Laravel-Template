<?php


namespace Modules\Property\Http\Resources;


use App\Http\Resources\BaseJsonResource;
use App\Models\FieldValue;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Filter\Http\Resources\FilterResource;
use Modules\Property\Models\Property;

/**
 * Class PropertyResource
 * @package Modules\Property\Http\Resources
 * @mixin Property
 */
class PropertyResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'filters' => FilterResource::collection($this->whenLoaded('filters')),
            'field_value_ids' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->field_value_ids;
            }),
            'fieldValues' => $this->whenPivotLoaded('product_property', function () {
                return FieldValue::whereIn('id', \Arr::wrap($this->pivot->field_value_ids))->pluck('value');
            }),
            'value' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->value;
            }),
            'pretty_key' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->pretty_key;
            }),
            'pretty_value' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->pretty_value;
            }),
            'is_important' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->is_important;
            }),
            'important_position' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->important_position;
            }),
            'important_value' => $this->whenPivotLoaded('product_property', function () {
                return $this->pivot->important_value;
            }),
        ]);
    }
}

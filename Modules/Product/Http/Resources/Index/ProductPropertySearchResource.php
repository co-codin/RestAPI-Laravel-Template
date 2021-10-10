<?php
namespace Modules\Product\Http\Resources\Index;


use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Property\Models\Property;

/**
 * Class ProductPropertySearchResource
 * @package Modules\Search\Services\Indices
 * @mixin Property
 */
class ProductPropertySearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'field_value_ids' => $this->pivot->field_value_ids,
            'value' => $this->pivot->value,
            'value_numeric' => $this->is_numeric
                ? (float) $this->pivot->value
                : null,
        ];
    }
}

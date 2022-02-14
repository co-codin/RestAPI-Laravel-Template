<?php


namespace Modules\Product\Models\Pivots;


use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Product\Models\ProductVariation;
use Modules\Property\Models\Property;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

/**
 * Class ProductPropertyPivot
 * @package Modules\Product\Models\Pivots
 * @property array|null $field_value_ids
 * @property-read Property $property
 * @property-read ProductVariation $productVariation
 * @property-read FieldValue[]|Collection $fieldValues
 */
class ProductVariationPropertyPivot extends Pivot
{
    use HasJsonRelationships;

    protected $casts = [
        'field_value_ids' => 'json',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'id', 'property_id');
    }

    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'id', 'product_variation_id');
    }

    public function fieldValues(): BelongsToJson
    {
        return $this->belongsToJson(FieldValue::class, 'field_value_ids');
    }
}

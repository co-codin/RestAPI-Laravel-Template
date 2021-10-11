<?php


namespace Modules\Product\Models\Pivots;


use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Property\Models\Property;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * Class ProductPropertyPivot
 * @package Modules\Product\Models\Pivots
 * @property array|null $field_value_ids
 * @property mixed $value
 * @property string|null $pretty_key
 * @property string|null $pretty_value
 * @property boolean $is_important
 * @property int|null $important_position
 * @property string|null $important_value
 * @property-read Property $property
 * @property-read FieldValue[]|Collection $fieldValues
 */
class ProductPropertyPivot extends Pivot
{
    use HasJsonRelationships;

    protected $casts = [
        'field_value_ids' => 'json',
        'value' => 'json',
        'is_important' => 'boolean',
        'important_position' => 'integer',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'id', 'property_id');
    }

    public function fieldValues()
    {
        return $this->belongsToJson(FieldValue::class, 'field_value_ids');
    }
}

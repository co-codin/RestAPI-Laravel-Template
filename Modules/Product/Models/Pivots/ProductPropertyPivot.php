<?php


namespace Modules\Product\Models\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Property\Models\Property;

/**
 * Class ProductPropertyPivot
 * @package Modules\Product\Models\Pivots
 * @property mixed $value
 * @property string|null $pretty_key
 * @property string|null $pretty_value
 * @property boolean $is_important
 * @property int|null $important_position
 * @property string|null $important_value
 */
class ProductPropertyPivot extends Pivot
{
    protected $casts = [
        'value' => 'json',
        'is_important' => 'boolean',
        'important_position' => 'integer',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'id', 'property_id');
    }
}

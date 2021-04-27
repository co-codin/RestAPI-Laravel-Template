<?php


namespace Modules\Product\Models\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Property\Models\Property;

class PropertyValuePivot extends Pivot
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

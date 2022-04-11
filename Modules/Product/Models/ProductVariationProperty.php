<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Property\Models\Property;

class ProductVariationProperty extends Model
{
    protected $guarded = ['id'];

    protected $table = 'product_variation_property';

    public $timestamps = false;

    protected $casts = [
        'product_variation_id' => 'integer',
        'property_id' => 'integer',
    ];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationProperty extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'product_variation_id' => 'integer',
        'property_id' => 'integer',
    ];

//    public
}

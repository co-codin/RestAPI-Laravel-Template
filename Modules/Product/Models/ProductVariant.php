<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\factories\ProductVariantFactory;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'product_id' => 'integer',
        'price' => 'integer',
        'previous_price' => 'integer',
        'currency_id' => 'integer',
        'is_price_visible' => 'boolean',
        'is_enabled' => 'boolean',
        'availability' => 'integer',
        'options' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory()
    {
        return ProductVariantFactory::new();
    }
}

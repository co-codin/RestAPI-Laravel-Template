<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\factories\ProductFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'integer',
        'brand_id' => 'integer',
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'warranty' => 'integer',
        'options' => 'array',
        'media' => 'array',
        'documents' => 'array',
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}

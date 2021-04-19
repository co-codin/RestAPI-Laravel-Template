<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Models\Category;
use Modules\Property\Database\factories\PropertyFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    protected $casts = [
        'type' => 'integer',
        'options' => 'array',
        'is_hidden_from_product' => 'boolean',
        'is_hidden_from_comparison' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'property_category',
            'property_id',
            'category_id'
        )->withPivot(['section']);
    }

    protected static function newFactory()
    {
        return PropertyFactory::new();
    }
}

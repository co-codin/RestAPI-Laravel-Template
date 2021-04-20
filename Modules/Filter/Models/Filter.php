<?php

namespace Modules\Filter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Models\Category;
use Modules\Filter\Database\factories\FilterFactory;
use Modules\Property\Models\Property;

class Filter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'integer',
        'is_enabled' => 'boolean',
        'is_default' => 'boolean',
        'position' => 'integer',
        'options' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    protected static function newFactory()
    {
        return FilterFactory::new();
    }
}

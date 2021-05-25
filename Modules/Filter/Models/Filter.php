<?php

namespace Modules\Filter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Models\Category;
use Modules\Filter\Concerns\Aggregable;
use Modules\Filter\Database\factories\FilterFactory;
use Modules\Property\Models\Property;

/**
 * Class Filter
 * @package Modules\Filter\Models
 * @property int $id
 * @property int $status
 * @property bool $is_default
 * @property bool $is_enabled
 * @property int $position
 * @property array $array
 * @property Property|null $property
 * @property Category|null $category
 */
class Filter extends Model
{
    use HasFactory, Aggregable;

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

<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Models\Category;
use Modules\Filter\Models\Filter;
use Modules\Property\Database\factories\PropertyFactory;

/**
 * Class Property
 * @package Modules\Property\Models
 * @property string $name
 * @property integer $type
 * @property array|null $options
 * @property string|null $description
 * @property bool is_hidden_from_product
 * @property bool is_hidden_from_comparison
 */
class Property extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
        )->withPivot(['section', 'position']);
    }

    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

    protected static function newFactory()
    {
        return PropertyFactory::new();
    }
}

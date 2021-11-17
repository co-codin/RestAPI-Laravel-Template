<?php

namespace Modules\Property\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Category\Models\Category;
use Modules\Filter\Models\Filter;
use Modules\Product\Models\Pivots\ProductPropertyPivot;
use Modules\Property\Database\factories\PropertyFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Property
 * @package Modules\Property\Models
 * @property int $id
 * @property string|null $name
 * @property string|null $key
 * @property array|null $options
 * @property string|null $description
 * @property bool is_hidden_from_product
 * @property bool is_hidden_from_comparison
 * @property bool $is_numeric
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property ProductPropertyPivot $pivot
 * @property Category $category
 * @property Filter[]|Collection $filters
 * @mixin \Eloquent
 * @method static Builder|Property newModelQuery()
 * @method static Builder|Property newQuery()
 * @method static Builder|Property query()
 */
class Property extends Model
{
    use HasFactory, LogsActivity, Sluggable;

    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array',
        'is_hidden_from_product' => 'boolean',
        'is_hidden_from_comparison' => 'boolean',
        'is_boolean' => 'boolean',
        'is_numeric' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'key' => [
                'source' => 'name',
            ]
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
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

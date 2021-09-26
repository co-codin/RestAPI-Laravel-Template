<?php

namespace Modules\Filter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;
use Modules\Filter\Collections\FilterCollection;
use Modules\Filter\Concerns\Aggregable;
use Modules\Filter\Concerns\HasValue;
use Modules\Filter\Database\factories\FilterFactory;
use Modules\Filter\Models\Types\CheckMarkFilter;
use Modules\Filter\Models\Types\CheckMarkListFilter;
use Modules\Filter\Models\Types\SliderFilter;
use Modules\Filter\Enums\FilterType;
use Modules\Property\Models\Property;
use Modules\Filter\Concerns\Searchable;
use Parental\HasChildren;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|Filter newModelQuery()
 * @method static Builder|Filter newQuery()
 * @method static Builder|Filter query()
 */
class Filter extends Model
{
    use HasFactory,
        Aggregable,
        Searchable,
        LogsActivity,
        HasChildren,
        HasValue;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'integer',
        'is_enabled' => 'boolean',
        'is_default' => 'boolean',
        'position' => 'integer',
        'options' => 'array',
    ];

    protected $childTypes = [
        FilterType::CheckMarkList => CheckMarkListFilter::class,
        FilterType::Slider => SliderFilter::class,
        FilterType::CheckMark => CheckMarkFilter::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'description',
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
    }

    protected static function newFactory()
    {
        return FilterFactory::new();
    }

    public function newCollection(array $models = []): FilterCollection
    {
        return new FilterCollection($models);
    }
}

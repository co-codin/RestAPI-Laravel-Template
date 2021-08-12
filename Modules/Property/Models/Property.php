<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Category\Models\Category;
use Modules\Filter\Models\Filter;
use Modules\Property\Models\Pivots\ProductPropertyPivot;
use Modules\Property\Database\factories\PropertyFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Property
 * @package Modules\Property\Models
 * @property int $id
 * @property string|null $name
 * @property int $type
 * @property array|null $options
 * @property string|null $description
 * @property bool is_hidden_from_product
 * @property bool is_hidden_from_comparison
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property ProductPropertyPivot $pivot
 * @mixin \Eloquent
 * @method static Builder|Property newModelQuery()
 * @method static Builder|Property newQuery()
 * @method static Builder|Property query()
 */
class Property extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'integer',
        'options' => 'array',
        'is_hidden_from_product' => 'boolean',
        'is_hidden_from_comparison' => 'boolean',
    ];

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

<?php

namespace Modules\Brand\Models;

use App\Concerns\IsActive;
use App\Models\FieldValue;
use App\Concerns\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Product\Models\Product;
use Modules\Seo\Models\Seo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Brand
 * @package Modules\Brand\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property boolean $is_in_home
 * @property int $status
 * @property string|null $short_description
 * @property string|null $full_description
 * @property string|integer $country_id
 * @property int|null $position
 * @property string|null $website
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Seo $seo
 * @property-read FieldValue $country
 * @property-read Product[]|Collection $products
 * @mixin \Eloquent
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 */
class Brand extends Model
{
    use HasFactory, Sluggable, IsActive, SoftDeletes, LogsActivity, Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'position' => 'integer',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'full_description',
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function country()
    {
        return $this->belongsTo(FieldValue::class);
    }

    protected static function newFactory()
    {
        return BrandFactory::new();
    }
}

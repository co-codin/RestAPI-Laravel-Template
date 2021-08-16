<?php

namespace Modules\Brand\Models;

use App\Concerns\IsActive;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;
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
 * @property string|null $country
 * @property int|null $position
 * @property string|null $website
 * @property-read Seo $seo
 * @property int|null Seo $seo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin \Eloquent
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 */
class Brand extends Model
{
    use HasFactory, Sluggable, IsActive, SoftDeletes, LogsActivity;

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

    protected static function newFactory()
    {
        return BrandFactory::new();
    }
}

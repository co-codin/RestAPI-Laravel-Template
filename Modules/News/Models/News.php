<?php

namespace Modules\News\Models;

use App\Concerns\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\News\Database\factories\NewsFactory;
use Modules\Seo\Models\Seo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class News
 * @package Modules\News\Models
 * @property int $id
 * @property string|null $name
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $full_description
 * @property integer $status
 * @property string|null $image
 * @property boolean $is_in_home
 * @property Carbon $published_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property ?Seo $seo
 * @mixin \Eloquent
 * @method static Builder|News newModelQuery()
 * @method static Builder|News newQuery()
 * @method static Builder|News query()
 */
class News extends Model
{
    use HasFactory, SoftDeletes, Sluggable, IsActive, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'published_at' => 'datetime:Y-m-d',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
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

    protected static function newFactory()
    {
        return NewsFactory::new();
    }
}

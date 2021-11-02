<?php

namespace Modules\News\Models;

use App\Concerns\IsActive;
use App\Enums\Status;
use Cviebrock\EloquentSluggable\Sluggable;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\News\Database\factories\NewsFactory;
use Modules\Seo\Models\Seo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
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
        'published_at' => 'datetime:d-m-Y',
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

    public function getOptimisedNews($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        return News::query()->select(array_keys($resolveInfo->getFieldSelection(1)['data']));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::ONLY_URL]);
    }

    public function getFormattedFullDescriptionAttribute()
    {
        $re = '/'
            . '(href=")'
            . '('
            . '(?!(https:\/\/|http:\/\/)?medeqstars\.ru|(https:\/\/|http:\/\/)?medeq\.ru)'
            . '(?:(?:https?|ftp):\/\/)?(?:\S+(?::\S*)?@)?'
            . '(?:'
            . '(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})'
            . '(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})'
            . '(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}'
            . '(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))'
            . '|'
            . '(?:(?:[a-z-0-9\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)'
            . '(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z-0-9\x{00a1}-\x{ffff}]{2,}))'
            . ')'
            . '(?::\d{2,5})?(?:\/[^\s]*)?"'
            . '(?<!medeqstars\.ru|medeq\.ru)'
            . ')'
            . '/iu';

        return preg_replace_callback($re, function ($matches) {
            return $matches[1] . '/go?to=' . $matches[2] . ' target="_blank"';
        }, $this->full_description);
    }

    protected static function newFactory()
    {
        return NewsFactory::new();
    }
}

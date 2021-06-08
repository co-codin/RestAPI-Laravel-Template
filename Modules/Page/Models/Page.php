<?php

namespace Modules\Page\Models;

use App\Concerns\IsActive;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Page\Database\factories\PageFactory;
use Modules\Seo\Models\Seo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Page
 * @package Modules\Page\Models
 * @property int $id
 * @property string $slug
 * @property string|null $full_description
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Seo|null $seo
 * @mixin \Eloquent
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 */
class Page extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, IsActive, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
    ];

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
        return PageFactory::new();
    }
}

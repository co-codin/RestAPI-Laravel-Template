<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Customer\Database\factories\CustomerReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Enums\CustomerType;
use Modules\Product\Models\Product;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Modules\Customer\Entities\CustomerReview
 *
 * @property int $id
 * @property string $position
 * @property string $author
 * @property int $type
 * @property string|null $video
 * @property string|null $review_file
 * @property int|bool $is_in_home
 * @property string $comment
 * @property string|null $logo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|CustomerReview newModelQuery()
 * @method static Builder|CustomerReview newQuery()
 * @method static Builder|CustomerReview query()
 */
class CustomerReview extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'type' => 'integer',
        'is_in_home' => 'boolean'
    ];

    protected $guarded = [
        'id',
    ];

    public function getTypeNameAttribute()
    {
        return CustomerType::getDescription($this->type);
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory(): CustomerReviewFactory
    {
        return CustomerReviewFactory::new();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Modules\Review\Models\ProductReview;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property int $subject
 * @property string $phone
 * @property string|null $email
 * @property Carbon|null $banned_at
 * @property Carbon|null $phone_verified_at
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|ProductReview[] $productReviews
 * @mixin \Eloquent
 * @method static QueryBuilder|Client withoutTrashed()
 * @method static QueryBuilder|Client withTrashed()
 * @method static QueryBuilder|Client onlyTrashed()
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 */
class Client extends Authenticatable
{
    use SoftDeletes, LogsActivity;

    protected $guarded = [
        'id',
        'phone_verified_at',
        'email_verified_at',
    ];

    protected $casts = [
        'ratings' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'first_name',
                'last_name',
                'subject',
                'phone',
                'email',
            ])
            ->logOnlyDirty();
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }
}

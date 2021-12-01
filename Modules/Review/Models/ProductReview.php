<?php

namespace Modules\Review\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Review\Database\factories\ProductReviewFactory;

/**
 * Class ProductReview
 * @package Modules\Review\Models
 * @property int $id
 * @property int $client_id
 * @property int $experience
 * @property string $advantages
 * @property string $disadvantages
 * @property string $comment
 * @property int $status
 * @property boolean $is_confirmed
 * @property array $ratings
 * @property int $like
 * @property int $dislike
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Client $client
 * @mixin \Eloquent
 * @method static Builder|ProductReview newModelQuery()
 * @method static Builder|ProductReview newQuery()
 * @method static Builder|ProductReview query()
 */
class ProductReview extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'ratings' => 'array',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected static function newFactory(): ProductReviewFactory
    {
        return ProductReviewFactory::new();
    }
}

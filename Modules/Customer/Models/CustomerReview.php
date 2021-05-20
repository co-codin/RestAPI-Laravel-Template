<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Customer\Database\factories\CustomerReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modules\Customer\Entities\CustomerReview
 *
 * @property int $id
 * @property string $post
 * @property string $author
 * @property int $type
 * @property string|null $video
 * @property string|null $review_file
 * @property int|bool $is_home
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
    use HasFactory;

    protected $casts = [
        'type' => 'integer',
        'is_home' => 'boolean'
    ];

    protected $fillable = [
        'post',
        'author',
        'type',
        'video',
        'review_file',
        'is_home',
        'comment',
        'logo',
    ];

    protected static function newFactory(): CustomerReviewFactory
    {
        return CustomerReviewFactory::new();
    }
}

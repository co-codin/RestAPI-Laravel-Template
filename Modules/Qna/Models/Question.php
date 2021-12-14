<?php

namespace Modules\Qna\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Qna\Database\factories\QuestionFactory;
use Modules\Qna\Enums\QuestionStatus;

/**
 * Class Question
 * @package Modules\Qna\Models
 * @property int $id
 * @property int $product_id
 * @property int|null $client_id
 * @property int $status
 * @property string $text
 * @property Carbon|null $created_at
 * @property-read Collection|Answer[] $answers
 * @property-read Client $client
 * @mixin \Eloquent
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 */
class Question extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function scopePublished($query): void
    {
        $query->where('status', QuestionStatus::APPROVED);
    }

    protected static function newFactory()
    {
        return QuestionFactory::new();
    }
}

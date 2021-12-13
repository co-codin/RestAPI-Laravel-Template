<?php

namespace Modules\Qna\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Qna\Database\factories\AnswerFactory;

/**
 * Class Answer
 * @package Modules\Qna\Models
 * @property int $id
 * @property int $question_id
 * @property string $text
 * @property string $name
 * @property int $like
 * @property int $dislike
 * @property Carbon|null $created_at
 * @property-read Question $question
 * @property-read Client $client
 * @mixin \Eloquent
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 */
class Answer extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected static function newFactory()
    {
        return AnswerFactory::new();
    }
}

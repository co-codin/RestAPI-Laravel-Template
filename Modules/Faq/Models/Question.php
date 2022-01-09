<?php

namespace Modules\Faq\Models;

use App\Concerns\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Faq\Database\factories\QuestionFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Question
 * @package Modules\Faq\Models
 * @property int $id
 * @property string $question
 * @property string $slug
 * @property string $answer
 * @property int $status
 * @property QuestionCategory $questionCategory
 * @mixin \Eloquent
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 */
class Question extends Model
{
    use HasFactory, SoftDeletes, IsActive, Sluggable, LogsActivity;

    protected $guarded = ['id'];

    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'question',
            ]
        ];
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

    protected static function newFactory()
    {
        return QuestionFactory::new();
    }
}

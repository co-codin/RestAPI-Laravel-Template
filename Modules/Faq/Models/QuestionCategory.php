<?php

namespace Modules\Faq\Models;

use App\Concerns\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Faq\Database\factories\QuestionCategoryFactory;

/**
 * Class QuestionCategory
 * @package Modules\Faq\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property int|null $position
 * @property Question[]|Collection $questions
 */
class QuestionCategory extends Model
{
    use HasFactory, SoftDeletes, IsActive, Sluggable;

    protected $guarded = ['id'];

    protected $casts = [
        'position' => 'integer',
        'status' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    protected static function newFactory()
    {
        return QuestionCategoryFactory::new();
    }
}

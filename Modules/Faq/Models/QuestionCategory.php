<?php

namespace Modules\Faq\Models;

use App\Traits\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Faq\Database\factories\QuestionCategoryFactory;

class QuestionCategory extends Model
{
    use HasFactory, SoftDeletes, IsActive, Sluggable;

    protected $guarded = ['id'];

    protected $casts = [
        'position' => 'integer',
        'status' => 'boolean',
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

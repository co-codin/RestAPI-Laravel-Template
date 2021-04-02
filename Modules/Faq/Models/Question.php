<?php

namespace Modules\Faq\Models;

use App\Traits\IsActive;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Faq\Database\factories\QuestionFactory;

class Question extends Model
{
    use HasFactory, SoftDeletes, IsActive, Sluggable;

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

    protected static function newFactory()
    {
        return QuestionFactory::new();
    }
}

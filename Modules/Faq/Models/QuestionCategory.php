<?php

namespace Modules\Faq\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Faq\Database\factories\QuestionCategoryFactory;
use Modules\Faq\Models\Traits\IsActive;

class QuestionCategory extends Model
{
    use HasFactory, SoftDeletes, IsActive;

    protected $guarded = ['id'];

    protected $casts = [
        'position' => 'integer',
        'status' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    protected static function newFactory()
    {
        return QuestionCategoryFactory::new();
    }
}

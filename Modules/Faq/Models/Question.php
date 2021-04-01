<?php

namespace Modules\Faq\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Faq\Database\factories\QuestionFactory;
use Modules\Faq\Models\Traits\IsActive;

class Question extends Model
{
    use HasFactory, SoftDeletes, IsActive;

    protected $guarded = ['id'];

    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    protected static function newFactory()
    {
        return QuestionFactory::new();
    }
}

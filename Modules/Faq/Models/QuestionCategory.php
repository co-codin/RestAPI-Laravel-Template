<?php

namespace Modules\Faq\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionCategory extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Faq\Database\factories\QuestionCategoryFactory::new();
    }
}

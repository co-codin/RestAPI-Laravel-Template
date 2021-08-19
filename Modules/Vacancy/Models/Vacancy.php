<?php

namespace Modules\Vacancy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Vacancy\Database\factories\VacancyFactory;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected static function newFactory()
    {
        return VacancyFactory::new();
    }
}

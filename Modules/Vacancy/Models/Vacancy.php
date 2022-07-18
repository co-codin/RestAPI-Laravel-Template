<?php

namespace Modules\Vacancy\Models;

use App\Concerns\IsActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Vacancy\Database\factories\VacancyFactory;

/**
 * Class Vacancy
 * @package Modules\Vacancy\Models
 * @property string $name
 * @property int $status
 */
class Vacancy extends Model
{
    use HasFactory, SoftDeletes, IsActive;

    protected $guarded = [
        'id',
    ];

    protected static function newFactory()
    {
        return VacancyFactory::new();
    }
}

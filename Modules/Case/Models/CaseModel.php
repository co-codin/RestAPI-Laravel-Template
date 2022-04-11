<?php

namespace Modules\Case\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Case\Database\factories\CaseFactory;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date:Y-m-d',
        'is_enabled' => 'boolean',
    ];

    protected static function newFactory()
    {
        return CaseFactory::new();
    }
}

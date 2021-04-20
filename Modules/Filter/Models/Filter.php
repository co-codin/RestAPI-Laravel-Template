<?php

namespace Modules\Filter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Filter\Database\factories\FilterFactory;

class Filter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'integer',
        'is_enabled' => 'boolean',
        'is_default' => 'boolean',
        'position' => 'integer',
        'options' => 'array',
    ];

    protected static function newFactory()
    {
        return FilterFactory::new();
    }
}

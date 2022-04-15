<?php

namespace Modules\Banner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Banner\Database\factories\BannerFactory;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_enabled' => 'boolean',
        'position' => 'integer',
        'images' => 'array',
    ];

    protected static function newFactory()
    {
        return BannerFactory::new();
    }
}

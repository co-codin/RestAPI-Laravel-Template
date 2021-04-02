<?php

namespace Modules\Publication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Publication\Database\factories\PublicationFactory;

class Publication extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date',
        'is_enabled' => 'boolean',
    ];

    protected static function newFactory()
    {
        return PublicationFactory::new();
    }
}

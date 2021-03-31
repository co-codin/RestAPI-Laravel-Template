<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seo\Database\factories\SeoFactory;

class Seo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'seo';

    protected static function newFactory()
    {
        return SeoFactory::new();
    }
}

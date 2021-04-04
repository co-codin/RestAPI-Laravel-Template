<?php

namespace Modules\News\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\Database\factories\NewsFactory;
use Modules\Seo\Models\Seo;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'is_in_home' => 'boolean',
        'published_at' => 'datetime:Y-m-d',
    ];

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function newFactory()
    {
        return NewsFactory::new();
    }
}

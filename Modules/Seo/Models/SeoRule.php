<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seo\Database\factories\SeoRuleFactory;
use Modules\Seo\Models\Traits\SeoBaseRelations;

class SeoRule extends Model
{
    use HasFactory, SeoBaseRelations;

    protected $guarded = ['id'];

    protected $casts = [
        'texts' => 'array'
    ];

    protected static function newFactory()
    {
        return SeoRuleFactory::new();
    }
}

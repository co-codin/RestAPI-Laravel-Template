<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seo\Database\factories\SeoRuleFactory;

/**
 * Class SeoRule
 * @package Modules\Seo\Models
 * @property string $name
 * @property string $url
 * @property Seo $seo
 */
class SeoRule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return SeoRuleFactory::new();
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}

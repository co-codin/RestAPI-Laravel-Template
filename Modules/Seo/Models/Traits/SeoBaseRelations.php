<?php


namespace Modules\Seo\Models\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Seo\Models\Seo;

/**
 * Trait SeoBaseRelations
 * @package Modules\Seo\Entities
 * @property-read Seo $seo
 * @property-read Seo $seoSelf
 * @property-read Seo $seoEnabled
 * @property-read Seo $seoWithoutEnabledAndType
 */
trait SeoBaseRelations
{
    /**
     * Get the morphObject's seo.
     */
    public function seo(): MorphOne
    {
        /** @var Model $this */
        return $this->morphOne(Seo::class, 'seoable');
    }

    /**
     * Get the morphObject's seo.
     */
    public function seoSelf(): MorphOne
    {
        /** @var Model $this */
        return $this->morphOne(Seo::class, 'seoable');
    }

    /**
     * Get the morphObject's seo.
     */
    public function seoEnabled(): MorphOne
    {
        /** @var Model $this */
        return $this->morphOne(Seo::class, 'seoable')
            ->where('is_enabled', '=', true);
    }

    /**
     * Get the morphObject's seo.
     */
    public function seoWithoutEnabledAndType(): MorphOne
    {
        /** @var Model $this */
        return $this->morphOne(Seo::class, 'seoable');
    }
}

<?php


namespace Modules\Seo\Facades;


use Modules\Filter\Helpers\FilterSeoHelper;

/**
 * Class CanonicalManager
 * @package Modules\Seo\Facades
 */
class CanonicalManager
{
    private ?string $canonical = null;

    public function setCanonical(string $canonical = null): self
    {
        $this->canonical = $canonical;

        return $this;
    }

    public function getCanonical(string $default = null): ?string
    {
        if (\Route::currentRouteName() === 'category-view-with-filters') {
            $default = FilterSeoHelper::modifyCanonical($default);
        }

        if (is_null($this->canonical)) {
            return $default;
        }

        return str_replace("medeqstars.ru", "medeq.ru", $this->canonical);
    }
}

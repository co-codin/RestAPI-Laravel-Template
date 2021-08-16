<?php


namespace Modules\Form\Casts;


use Modules\Brand\Models\Brand;

/**
 * Class BrandCast
 * @package Modules\Form\Casts
 */
class BrandCast implements CastsInterface
{
    private ?Brand $brand = null;

    /**
     * @param string $slug
     * @return Brand|null
     */
    public function get($slug): ?Brand
    {
        if (!is_null($this->brand)) {
            return $this->brand;
        }

        return $this->brand = Brand::query()
            ->where('slug', $slug)
            ->first();
    }
}

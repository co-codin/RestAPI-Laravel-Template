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
     * @param string $id
     * @return Brand|null
     */
    public function get($id): ?Brand
    {
        if (!is_null($this->brand)) {
            return $this->brand;
        }

        return $this->brand = Brand::query()
            ->where('id', $id)
            ->first();
    }
}

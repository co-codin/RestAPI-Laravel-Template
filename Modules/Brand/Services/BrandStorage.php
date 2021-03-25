<?php


namespace Modules\Brand\Services;


use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Models\Brand;

class BrandStorage
{
    public function store(BrandDto $brandDto)
    {
        return Brand::query()->create($brandDto->toArray());
    }

    public function update(Brand $brand, BrandDto $brandDto)
    {
        if (!$brand->update($brandDto->toArray())) {
            throw new \LogicException('can not update brand');
        }

        return $brand;
    }

    public function delete(Brand $brand)
    {
        if (!$brand->delete()) {
            throw new \LogicException('can not delete brand');
        }
    }
}

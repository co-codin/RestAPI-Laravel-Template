<?php


namespace Modules\Brand\Services;


use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Models\Brand;

class BrandStorage
{
    public function store(BrandDto $brandDto)
    {
        $brand = Brand::query()->create($brandDto->toArray());

        return $brand;
    }

    public function update(int $brand, BrandDto $brandDto)
    {
        $brand = Brand::query()->find($brand)->update($brandDto->toArray());

        return $brand;
    }

    public function delete(int $brand)
    {
        return Brand::query()->find($brand)->delete();
    }
}

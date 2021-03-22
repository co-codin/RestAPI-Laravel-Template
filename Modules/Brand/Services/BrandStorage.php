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

    public function update($brand, BrandDto $brandDto)
    {
        return $brand->update($brandDto->toArray());
    }

    public function delete($brand)
    {
        return $brand->delete();
    }
}

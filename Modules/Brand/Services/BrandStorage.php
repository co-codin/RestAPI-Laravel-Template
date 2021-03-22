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

    public function update(int $brand, BrandDto $brandDto)
    {
        return Brand::query()->find($brand)->update($brandDto->toArray());
    }

    public function delete(int $brand)
    {
        return Brand::query()->find($brand)->delete();
    }
}

<?php


namespace Modules\Brand\Services;


use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Events\BrandSaved;
use Modules\Brand\Models\Brand;

class BrandStorage
{
    public function store(BrandDto $brandDto)
    {
        $attributes = $brandDto->toArray();

        $brand = Brand::query()->create($attributes);

        event(new BrandSaved($brand));

        return $brand;
    }

    public function update(Brand $brand, BrandDto $brandDto)
    {
        $attributes = $brandDto->toArray();

        if($brandDto->is_image_changed) {
            $attributes['image'] = $brandDto->image
                ?: null;
        }

        if (!$brand->update($attributes)) {
            throw new \LogicException('can not update brand');
        }

        event(new BrandSaved($brand));

        return $brand;
    }

    public function delete(Brand $brand)
    {
        if (!$brand->delete()) {
            throw new \LogicException('can not delete brand');
        }
    }
}

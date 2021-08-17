<?php


namespace Modules\Brand\Services;


use App\Services\File\ImageUploader;
use Modules\Brand\Dto\BrandDto;
use Modules\Brand\Models\Brand;

class BrandStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(BrandDto $brandDto)
    {
        $attributes = $brandDto->toArray();

        if ($brandDto->image) {
            $attributes['image'] = $this->imageUploader->upload($brandDto->image);
        }

        $attributes['assigned_by_id'] = $brandDto->assigned_by_id ?? auth('custom-token')->id();

        return Brand::query()->create($attributes);
    }

    public function update(Brand $brand, BrandDto $brandDto)
    {
        $attributes = $brandDto->toArray();

        if ($brandDto->image) {
            $attributes['image'] = $this->imageUploader->upload($brandDto->image);
        }

        if (!$brand->update($attributes)) {
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

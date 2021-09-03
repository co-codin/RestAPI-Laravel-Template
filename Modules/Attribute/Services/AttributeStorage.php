<?php


namespace Modules\Attribute\Services;


use Modules\Attribute\Dto\AttributeDto;
use Modules\Attribute\Models\Attribute;

class AttributeStorage
{
    public function store(AttributeDto $attributeDto)
    {
        $attributes = $attributeDto->toArray();

        return Attribute::query()->create($attributes);
    }

    public function update(Attribute $attribute, AttributeDto $attributeDto)
    {
        $attributes = $attributeDto->toArray();

        $attribute->update($attributes);

        return $attribute;
    }

    public function delete(Attribute $attribute)
    {
        $attribute->delete();
    }
}

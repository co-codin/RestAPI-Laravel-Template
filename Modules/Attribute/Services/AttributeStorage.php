<?php


namespace Modules\Attribute\Services;


use Modules\Attribute\Dto\AttributeDto;
use Modules\Attribute\Models\Attribute;

class AttributeStorage
{
    public function store(AttributeDto $attributeDto)
    {
        return Attribute::query()->create($attributeDto->toArray());
    }

    public function update(Attribute $attribute, AttributeDto $attributeDto)
    {
        $attribute->update($attributeDto->toArray());

        return $attribute;
    }

    public function delete(Attribute $attribute)
    {
        $attribute->delete();
    }
}

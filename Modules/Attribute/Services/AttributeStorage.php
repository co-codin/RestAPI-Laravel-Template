<?php


namespace Modules\Attribute\Services;


use Modules\Attribute\Dto\AttributeDto;
use Modules\Attribute\Models\Attribute;

class AttributeStorage
{
    public function store(AttributeDto $attributeDto)
    {
        $attribute = Attribute::query()->create($attributeDto->toArray());

        return $attribute;
    }

    public function update(Attribute $attribute, AttributeDto $attributeDto)
    {

    }

    public function delete(Attribute $attribute)
    {

    }
}

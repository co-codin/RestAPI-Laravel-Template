<?php


namespace Modules\Property\Services;


use Modules\Property\Dto\PropertyDto;
use Modules\Property\Models\Property;

class PropertyStorage
{
    public function store(PropertyDto $propertyDto)
    {
        $property = new Property($propertyDto->toArray());

        if (!$property->save()) {
            throw new \LogicException('can not create property.');
        }

        return $property;
    }

    public function update(Property $property, PropertyDto $propertyDto)
    {
        if (!$property->update($propertyDto->toArray())) {
            throw new \LogicException('can not update property.');
        }

        return $property;
    }

    public function delete(Property $property)
    {
        if (!$property->delete()) {
            throw new \LogicException('can not delete property.');
        }
    }
}

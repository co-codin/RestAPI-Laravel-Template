<?php


namespace Modules\Property\Services;


use Modules\Property\Dto\PropertyDto;
use Modules\Property\Models\Property;

class PropertyStorage
{
    public function store(PropertyDto $propertyDto)
    {
        $attributes = $propertyDto->toArray();

        $attributes['assigned_by_id'] = $propertyDto->assigned_by_id ?? auth('custom-token')->id();

        $property = new Property($attributes);

        if (!$property->save()) {
            throw new \LogicException('can not create property.');
        }

        return $property;
    }

    public function update(Property $property, PropertyDto $propertyDto)
    {
        $attributes = $propertyDto->toArray();

        $attributes['assigned_by_id'] = $propertyDto->assigned_by_id ?? null;

        if (!$property->update($attributes)) {
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

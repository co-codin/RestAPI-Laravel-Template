<?php


namespace Modules\Property\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Property\Dto\PropertyDto;
use Modules\Property\Http\Requests\PropertyCreateRequest;
use Modules\Property\Http\Requests\PropertyUpdateRequest;
use Modules\Property\Http\Resources\PropertyResource;
use Modules\Property\Models\Property;
use Modules\Property\Services\PropertyStorage;

class PropertyController extends Controller
{
    public function __construct(
        protected PropertyStorage $propertyStorage,
    ) {
        $this->authorizeResource(Property::class, 'property');
    }

    public function store(PropertyCreateRequest $request)
    {
        $propertyDto = PropertyDto::fromFormRequest($request);

        if (!$propertyDto->assigned_by_id) {
            $propertyDto->assigned_by_id = auth('sanctum')->id();
        }

        $property = $this->propertyStorage->store($propertyDto);

        return new PropertyResource($property);
    }

    public function update(Property $property, PropertyUpdateRequest $request)
    {
        $property = $this->propertyStorage->update($property, PropertyDto::fromFormRequest($request));

        return new PropertyResource($property);
    }

    public function destroy(Property $property)
    {
        $this->propertyStorage->delete($property);

        return response()->noContent();
    }
}

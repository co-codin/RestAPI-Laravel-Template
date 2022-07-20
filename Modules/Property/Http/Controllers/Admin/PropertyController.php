<?php


namespace Modules\Property\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Property\Dto\PropertyDto;
use Modules\Property\Http\Requests\PropertyCreateRequest;
use Modules\Property\Http\Requests\PropertyUpdateRequest;
use Modules\Property\Http\Resources\PropertyResource;
use Modules\Property\Models\Property;
use Modules\Property\Repositories\PropertyRepository;
use Modules\Property\Services\PropertyStorage;

class PropertyController extends Controller
{
    public function __construct(
        protected PropertyStorage $propertyStorage,
        protected PropertyRepository $propertyRepository
    ) {}

    public function store(PropertyCreateRequest $request)
    {
        $this->authorize('create', Property::class);

        $propertyDto = PropertyDto::fromFormRequest($request);

        if (!$propertyDto->assigned_by_id) {
            $propertyDto->assigned_by_id = auth('sanctum')->id();
        }

        $property = $this->propertyStorage->store($propertyDto);

        return new PropertyResource($property);
    }

    public function update(int $property, PropertyUpdateRequest $request)
    {
        $property = $this->propertyRepository->find($property);

        $this->authorize('update', $property);

        $property = $this->propertyStorage->update($property, PropertyDto::fromFormRequest($request));

        return new PropertyResource($property);
    }

    public function destroy(int $property)
    {
        $property = $this->propertyRepository->find($property);

        $this->authorize('delete', $property);

        $this->propertyStorage->delete($property);

        return response()->noContent();
    }
}

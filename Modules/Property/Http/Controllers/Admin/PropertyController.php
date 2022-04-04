<?php


namespace Modules\Property\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Property\Dto\PropertyDto;
use Modules\Property\Http\Requests\PropertyCreateRequest;
use Modules\Property\Http\Requests\PropertyUpdateRequest;
use Modules\Property\Http\Resources\PropertyResource;
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
        $propertyDto = PropertyDto::fromFormRequest($request);

        if (!$propertyDto->assigned_by_id) {
            $propertyDto->assigned_by_id = auth('sanctum')->id();
        }

        $property = $this->propertyStorage->store($propertyDto);

        return new PropertyResource($property);
    }

    public function update(int $property, PropertyUpdateRequest $request)
    {
        $propertyModel = $this->propertyRepository->find($property);

        $propertyModel = $this->propertyStorage->update($propertyModel, PropertyDto::fromFormRequest($request));

        return new PropertyResource($propertyModel);
    }

    public function destroy(int $property)
    {
        $propertyModel = $this->propertyRepository->find($property);

        $this->propertyStorage->delete($propertyModel);

        return response()->noContent();
    }
}

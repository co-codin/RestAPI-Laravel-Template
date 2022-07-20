<?php


namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Property\Http\Resources\PropertyResource;
use Modules\Property\Models\Property;
use Modules\Property\Repositories\PropertyRepository;

class PropertyController extends Controller
{
    public function __construct(
        protected PropertyRepository $propertyRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Property::class);

        $properties = $this->propertyRepository->jsonPaginate();

        return PropertyResource::collection($properties);
    }

    public function all()
    {
        $this->authorize('viewAny', Property::class);

        $properties = $this->propertyRepository->all();

        return PropertyResource::collection($properties);
    }

    public function show(int $property)
    {
        $property = $this->propertyRepository->find($property);

        $this->authorize('view', $property);

        return new PropertyResource($property);
    }
}

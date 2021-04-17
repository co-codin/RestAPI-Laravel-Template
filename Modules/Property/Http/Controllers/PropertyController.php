<?php


namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Property\Http\Resources\PropertyResource;
use Modules\Property\Repositories\PropertyRepository;

class PropertyController extends Controller
{
    public function __construct(
        protected PropertyRepository $propertyRepository
    ) {}

    public function index()
    {
        $properties = $this->propertyRepository->jsonPaginate();

        return PropertyResource::collection($properties);
    }

    public function show(int $property)
    {
        $property = $this->propertyRepository->find($property);

        return new PropertyResource($property);
    }
}

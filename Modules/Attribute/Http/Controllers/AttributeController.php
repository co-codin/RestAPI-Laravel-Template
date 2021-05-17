<?php

namespace Modules\Attribute\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Attribute\Http\Resources\AttributeResource;
use Modules\Attribute\Repositories\AttributeRepository;

class AttributeController extends Controller
{
    public function __construct(
        protected AttributeRepository $attributeRepository
    ){}

    public function index()
    {
        $attributes = $this->attributeRepository->jsonPaginate();

        return AttributeResource::collection($attributes);
    }

    public function show(int $attribute)
    {
        $attribute = $this->attributeRepository->find($attribute);

        return new AttributeResource($attribute);
    }
}

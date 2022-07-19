<?php

namespace Modules\Attribute\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Attribute\Http\Resources\AttributeResource;
use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Repositories\AttributeRepository;

class AttributeController extends Controller
{
    public function __construct(
        protected AttributeRepository $attributeRepository
    ){
        $this->authorizeResource(Attribute::class, 'attribute');
    }

    public function index()
    {
        $attributes = $this->attributeRepository->jsonPaginate();

        return AttributeResource::collection($attributes);
    }

    public function show(Attribute $attribute)
    {
        return new AttributeResource($attribute);
    }
}

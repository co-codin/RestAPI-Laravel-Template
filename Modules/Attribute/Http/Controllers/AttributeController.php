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
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Attribute::class);

        $attributes = $this->attributeRepository->jsonPaginate();

        return AttributeResource::collection($attributes);
    }

    public function show(int $attribute)
    {
        $attribute = $this->attributeRepository->find($attribute);

        $this->authorize('viewAny', $attribute);

        return new AttributeResource($attribute);
    }
}

<?php

namespace Modules\Attribute\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Attribute\Dto\AttributeDto;
use Modules\Attribute\Http\Requests\Admin\AttributeCreateRequest;
use Modules\Attribute\Http\Requests\Admin\AttributeUpdateRequest;
use Modules\Attribute\Http\Resources\AttributeResource;
use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Attribute\Services\AttributeStorage;

class AttributeController extends Controller
{
    public function __construct(
        protected AttributeStorage $attributeStorage,
        protected AttributeRepository $attributeRepository
    ) {}

    public function store(AttributeCreateRequest $request)
    {
        $this->authorize('create', Attribute::class);

        $attributeDto = AttributeDto::fromFormRequest($request);

        if (!$attributeDto->assigned_by_id) {
            $attributeDto->assigned_by_id = auth('sanctum')->id();
        }

        $attribute = $this->attributeStorage->store($attributeDto);

        return new AttributeResource($attribute);
    }

    public function update(int $attribute, AttributeUpdateRequest $request)
    {
        $attribute = $this->attributeRepository->find($attribute);

        $this->authorize('update', $attribute);

        $this->attributeStorage->update($attribute, AttributeDto::fromFormRequest($request));

        return new AttributeResource($attribute);
    }

    public function destroy(int $attribute)
    {
        $attribute = $this->attributeRepository->find($attribute);

        $this->authorize('delete', $attribute);

        $this->attributeStorage->delete($attribute);

        return response()->noContent();
    }
}

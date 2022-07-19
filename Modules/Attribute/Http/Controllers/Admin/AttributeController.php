<?php

namespace Modules\Attribute\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Attribute\Dto\AttributeDto;
use Modules\Attribute\Http\Requests\Admin\AttributeCreateRequest;
use Modules\Attribute\Http\Requests\Admin\AttributeUpdateRequest;
use Modules\Attribute\Http\Resources\AttributeResource;
use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Services\AttributeStorage;

class AttributeController extends Controller
{
    public function __construct(
        protected AttributeStorage $attributeStorage
    ){
        $this->authorizeResource(Attribute::class, 'attribute');
    }

    public function store(AttributeCreateRequest $request)
    {
        $attributeDto = AttributeDto::fromFormRequest($request);

        if (!$attributeDto->assigned_by_id) {
            $attributeDto->assigned_by_id = auth('sanctum')->id();
        }

        $attribute = $this->attributeStorage->store($attributeDto);

        return new AttributeResource($attribute);
    }

    public function update(Attribute $attribute, AttributeUpdateRequest $request)
    {
        $this->attributeStorage->update($attribute, AttributeDto::fromFormRequest($request));

        return new AttributeResource($attributeModel);
    }

    public function destroy(Attribute $attribute)
    {
        $this->attributeStorage->delete($attribute);

        return response()->noContent();
    }
}

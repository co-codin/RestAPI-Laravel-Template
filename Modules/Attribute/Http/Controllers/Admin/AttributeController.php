<?php

namespace Modules\Attribute\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Attribute\Dto\AttributeDto;
use Modules\Attribute\Http\Requests\AttributeCreateRequest;
use Modules\Attribute\Http\Requests\AttributeUpdateRequest;
use Modules\Attribute\Http\Resources\AttributeResource;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Attribute\Services\AttributeStorage;

class AttributeController extends Controller
{
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected AttributeStorage $attributeStorage
    ){}

    public function store(AttributeCreateRequest $request)
    {
        $attribute = $this->attributeStorage->store(AttributeDto::fromFormRequest($request));

        return new AttributeResource($attribute);
    }

    public function update(int $attribute, AttributeUpdateRequest $request)
    {

    }

    public function destroy()
    {

    }
}

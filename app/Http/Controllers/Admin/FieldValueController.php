<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FieldValueCreateRequest;
use App\Http\Requests\Admin\FieldValueUpdateRequest;
use App\Http\Resources\FieldValueResource;
use App\Models\FieldValue;
use App\Repositories\FieldValueRepository;
use App\Services\FieldValueDestroyService;
use App\Services\FieldValueStorage;
use Illuminate\Http\Response;

class FieldValueController extends Controller
{
    public function __construct(
        protected FieldValueStorage $fieldValueStorage,
        protected FieldValueRepository $fieldValueRepository,
    ) {}

    public function store(FieldValueCreateRequest $request)
    {
        $this->authorize('create', FieldValue::class);

        $model = $this->fieldValueStorage->store($request->validated());

        return new FieldValueResource($model);
    }

    public function update(int $field_value, FieldValueUpdateRequest $request)
    {
        $fieldValueModel = $this->fieldValueRepository->find($field_value);

        $this->authorize('update', $fieldValueModel);

        $fieldValueModel = $this->fieldValueStorage->update($fieldValueModel, $request->validated());

        return new FieldValueResource($fieldValueModel);
    }

    public function destroy(FieldValueDestroyService $destroyService, int $fieldValueId): Response
    {
        $fieldValue = $this->fieldValueRepository->find($fieldValueId);

        $this->authorize('delete', $fieldValue);

        try {
            $destroyService->delete($fieldValue);
        }
        catch (\LogicException $exception) {
            abort(Response::HTTP_FORBIDDEN, $exception->getMessage());
        }

        return response()->noContent();
    }
}

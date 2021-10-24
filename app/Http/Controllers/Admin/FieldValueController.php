<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FieldValueCreateRequest;
use App\Http\Resources\FieldValueResource;
use App\Services\FieldValueStorage;

class FieldValueController extends Controller
{
    public function __construct(
        protected FieldValueStorage $fieldValueStorage
    ) {}

    public function store(FieldValueCreateRequest $request)
    {
        $model = $this->fieldValueStorage->store($request->validated());

        return new FieldValueResource($model);
    }
}

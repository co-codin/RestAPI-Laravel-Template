<?php

namespace App\Http\Controllers;

use App\Http\Resources\FieldValueResource;
use App\Repositories\FieldValueRepository;

class FieldValueController extends Controller
{
    public function __construct(
        protected FieldValueRepository $fieldValueRepository
    ) {}

    public function index()
    {
        $fieldValues = $this->fieldValueRepository->jsonPaginate(500);

        return FieldValueResource::collection($fieldValues);
    }
    public function show(int $fieldValueId)
    {
        $fieldValue = $this->fieldValueRepository->find($fieldValueId);

        return new FieldValueResource($fieldValue);
    }
}

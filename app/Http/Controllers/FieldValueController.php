<?php

namespace App\Http\Controllers;

use App\Http\Resources\FieldValueResource;
use App\Repositories\FieldValueRepository;
use Illuminate\Http\Request;

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
}

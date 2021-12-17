<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DocumentGroupCreateRequest;
use App\Http\Resources\DocumentGroupResource;
use App\Services\DocumentGroupStorage;

class DocumentGroupController extends Controller
{
    public function __construct(
        protected DocumentGroupStorage $documentGroupStorage
    ) {}

    public function store(DocumentGroupCreateRequest $request)
    {
        $documentGroup = $this->documentGroupStorage->store($request->validated());

        return new DocumentGroupResource($documentGroup);
    }
}

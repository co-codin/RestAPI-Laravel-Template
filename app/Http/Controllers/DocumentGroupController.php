<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentGroupResource;
use App\Repositories\DocumentGroupRepository;

class DocumentGroupController extends Controller
{
    public function __construct(
        protected DocumentGroupRepository $documentGroupRepository
    ) {}

    public function index()
    {
        $documentGroups = $this->documentGroupRepository->jsonPaginate(500);

        return DocumentGroupResource::collection($documentGroups);
    }
}

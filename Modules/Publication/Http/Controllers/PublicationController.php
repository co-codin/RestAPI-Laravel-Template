<?php

namespace Modules\Publication\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Publication\Http\Resources\PublicationResource;
use Modules\Publication\Repositories\PublicationRepository;

class PublicationController extends Controller
{
    public function __construct(
        protected PublicationRepository $publicationRepository
    ) {}

    public function index()
    {
        $publications = $this->publicationRepository->jsonPaginate();

        return PublicationResource::collection($publications);
    }

    public function show(int $publication)
    {
        $publication = $this->publicationRepository->find($publication);

        return new PublicationResource($publication);
    }
}

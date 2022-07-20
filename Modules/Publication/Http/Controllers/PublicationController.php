<?php

namespace Modules\Publication\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Publication\Http\Resources\PublicationResource;
use Modules\Publication\Models\Publication;
use Modules\Publication\Repositories\PublicationRepository;

class PublicationController extends Controller
{
    public function __construct(
        protected PublicationRepository $publicationRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Publication::class);

        $publications = $this->publicationRepository->jsonPaginate();

        return PublicationResource::collection($publications);
    }

    public function show(int $publication)
    {
        $publication = $this->publicationRepository->find($publication);

        $this->authorize('view', $publication);

        return new PublicationResource($publication);
    }
}

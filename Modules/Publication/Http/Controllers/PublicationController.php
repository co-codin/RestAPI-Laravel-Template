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
    ) {
        $this->authorizeResource(Publication::class, 'publication');
    }

    public function index()
    {
        $publications = $this->publicationRepository->jsonPaginate();

        return PublicationResource::collection($publications);
    }

    public function show(Publication $publication)
    {
        return new PublicationResource($publication);
    }
}

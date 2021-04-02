<?php

namespace Modules\Publication\Http\Controllers\Admin;

use App\Repositories\Criteria\IsEnabledCriteria;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Publication\Http\Requests\PublicationCreateRequest;
use Modules\Publication\Http\Resources\PublicationResource;
use Modules\Publication\Repositories\PublicationRepository;
use Modules\Publication\Services\PublicationStorage;

class PublicationController extends Controller
{
    public function __construct(
        protected PublicationRepository $publicationRepository,
        protected PublicationStorage $publicationStorage
    ) {
        $this->publicationRepository->popCriteria(IsEnabledCriteria::class);
    }

    public function index()
    {
        $publications = $this->publicationRepository->jsonPaginate();

        return PublicationResource::collection($publications);
    }

    public function show(string $slug)
    {
        $publication = $this->publicationRepository->findWhere([
            'slug' => $slug,
        ]);

        return new PublicationResource($publication);
    }

    public function store(PublicationCreateRequest $request)
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}

<?php

namespace Modules\Publication\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Publication\Dto\PublicationDto;
use Modules\Publication\Http\Requests\PublicationCreateRequest;
use Modules\Publication\Http\Requests\PublicationUpdateRequest;
use Modules\Publication\Http\Resources\PublicationResource;
use Modules\Publication\Models\Publication;
use Modules\Publication\Repositories\PublicationRepository;
use Modules\Publication\Services\PublicationStorage;

class PublicationController extends Controller
{
    public function __construct(
        protected PublicationStorage $publicationStorage,
        protected PublicationRepository $publicationRepository
    ) {}

    public function store(PublicationCreateRequest $request)
    {
        $this->authorize('create', Publication::class);

        $publicationDto = PublicationDto::fromFormRequest($request);

        if (!$publicationDto->assigned_by_id) {
            $publicationDto->assigned_by_id = auth('sanctum')->id();
        }

        $publication = $this->publicationStorage->store($publicationDto);

        return new PublicationResource($publication);
    }

    public function update(int $publication, PublicationUpdateRequest $request)
    {
        $publication = $this->publicationRepository->find($publication);

        $this->authorize('update', $publication);

        $publication = $this->publicationStorage->update($publication, (new PublicationDto($request->validated()))->only(...$request->keys()));

        return new PublicationResource($publication);
    }

    public function destroy(int $publication)
    {
        $publication = $this->publicationRepository->find($publication);

        $this->authorize('delete', $publication);

        $this->publicationStorage->delete($publication);

        return response()->noContent();
    }
}

<?php

namespace Modules\Publication\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Publication\Dto\PublicationDto;
use Modules\Publication\Http\Requests\PublicationCreateRequest;
use Modules\Publication\Http\Requests\PublicationUpdateRequest;
use Modules\Publication\Http\Resources\PublicationResource;
use Modules\Publication\Models\Publication;
use Modules\Publication\Services\PublicationStorage;

class PublicationController extends Controller
{
    public function __construct(
        protected PublicationStorage $publicationStorage
    ) {
        $this->authorizeResource(Publication::class, 'publication');
    }

    public function store(PublicationCreateRequest $request)
    {
        $publicationDto = PublicationDto::fromFormRequest($request);

        if (!$publicationDto->assigned_by_id) {
            $publicationDto->assigned_by_id = auth('sanctum')->id();
        }

        $publication = $this->publicationStorage->store($publicationDto);

        return new PublicationResource($publication);
    }

    public function update(Publication $publication, PublicationUpdateRequest $request)
    {
        $publication = $this->publicationStorage->update($publication, (new PublicationDto($request->validated()))->only(...$request->keys()));

        return new PublicationResource($publication);
    }

    public function destroy(Publication $publication)
    {
        $this->publicationStorage->delete($publication);

        return response()->noContent();
    }
}

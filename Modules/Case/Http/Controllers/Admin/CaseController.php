<?php

namespace Modules\Case\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryUpdateRequest;
use App\Services\File\ImageStorage;
use Modules\Cabinet\Models\Cabinet;
use Modules\Case\Dto\CaseDto;
use Modules\Case\Http\Requests\CaseCreateRequest;
use Modules\Case\Http\Requests\CaseUpdateRequest;
use Modules\Case\Http\Resources\CaseResource;
use Modules\Case\Repositories\CaseRepository;
use Modules\Case\Services\CaseStorage;

class CaseController extends Controller
{
    public function __construct(
        protected CaseStorage $caseStorage,
        protected ImageStorage $imageStorage,
        protected CaseRepository $caseRepository
    ) {}

    public function store(CaseCreateRequest $request)
    {
        $this->authorize('create', Cabinet::class);

        $case = $this->caseStorage->store(CaseDto::fromFormRequest($request));

        return new CaseResource($case);
    }

    public function update(int $case, CaseUpdateRequest $request)
    {
        $case = $this->caseRepository->find($case);

        $this->authorize('update', $case);

        $case = $this->caseStorage->update($case, CaseDto::fromFormRequest($request));

        return new CaseResource($case);
    }

    public function updateImages(int $case, GalleryUpdateRequest $request)
    {
        $case = $this->caseRepository->find($case);

        $this->imageStorage->update($case, $request->input('images', []));

        return new CaseResource($case);
    }

    public function destroy(int $case)
    {
        $case = $this->caseRepository->find($case);

        $this->authorize('delete', $case);

        $this->caseStorage->delete($case);

        return response()->noContent();
    }
}

<?php

namespace Modules\Case\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
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
        protected CaseRepository $caseRepository
    ) {}

    public function store(CaseCreateRequest $request)
    {
        $caseDto = CaseDto::fromFormRequest($request);

        $case = $this->caseStorage->store($caseDto);

        return new CaseResource($case);
    }

    public function update(int $case, CaseUpdateRequest $request)
    {
        $caseModel = $this->caseRepository->find($case);

        $caseModel = $this->caseStorage->update($caseModel, CaseDto::fromFormRequest($request));

        return new CaseResource($caseModel);
    }

    public function destroy(int $case)
    {
        $caseModel = $this->caseRepository->find($case);

        $this->caseStorage->delete($caseModel);

        return response()->noContent();
    }
}

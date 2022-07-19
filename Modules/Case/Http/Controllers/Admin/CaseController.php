<?php

namespace Modules\Case\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Case\Dto\CaseDto;
use Modules\Case\Http\Requests\CaseCreateRequest;
use Modules\Case\Http\Requests\CaseUpdateRequest;
use Modules\Case\Http\Resources\CaseResource;
use Modules\Case\Models\CaseModel;
use Modules\Case\Repositories\CaseRepository;
use Modules\Case\Services\CaseStorage;

class CaseController extends Controller
{
    public function __construct(
        protected CaseStorage $caseStorage,
        protected CaseRepository $caseRepository
    ) {
        $this->authorizeResource(CaseModel::class, 'case');
    }

    public function store(CaseCreateRequest $request)
    {
        $case = $this->caseStorage->store(CaseDto::fromFormRequest($request));

        return new CaseResource($case);
    }

    public function update(CaseModel $case, CaseUpdateRequest $request)
    {
        $case = $this->caseStorage->update($case, CaseDto::fromFormRequest($request));

        return new CaseResource($case);
    }

    public function destroy(CaseModel $case)
    {
        $this->caseStorage->delete($case);

        return response()->noContent();
    }
}

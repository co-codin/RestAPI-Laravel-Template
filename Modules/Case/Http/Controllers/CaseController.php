<?php

namespace Modules\Case\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Case\Http\Resources\CaseResource;
use Modules\Case\Models\CaseModel;
use Modules\Case\Repositories\CaseRepository;

class CaseController extends Controller
{
    public function __construct(
        protected CaseRepository $caseRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', CaseModel::class);

        $cases = $this->caseRepository->jsonPaginate();

        return CaseResource::collection($cases);
    }

    public function show(int $case)
    {
        $case = $this->caseRepository->find($case);

        $this->authorize('view', $case);

        return new CaseResource($case);
    }
}

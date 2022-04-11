<?php

namespace Modules\Case\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Case\Http\Resources\CaseResource;
use Modules\Case\Repositories\CaseRepository;

class CaseController extends Controller
{
    public function __construct(
        protected CaseRepository $caseRepository
    ) {}

    public function index()
    {
        $cases = $this->caseRepository->jsonPaginate();

        return CaseResource::collection($cases);
    }

    public function show(int $case)
    {
        $case = $this->caseRepository->find($case);

        return new CaseResource($case);
    }
}

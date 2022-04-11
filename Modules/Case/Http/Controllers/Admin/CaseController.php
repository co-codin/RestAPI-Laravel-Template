<?php

namespace Modules\Case\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Case\Http\Requests\CaseCreateRequest;
use Modules\Case\Http\Requests\CaseUpdateRequest;
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

    }

    public function update(int $case, CaseUpdateRequest $request)
    {

    }
}

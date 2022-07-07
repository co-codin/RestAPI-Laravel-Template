<?php

namespace Modules\Case\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Case\Http\Resources\CasePageResource;
use Modules\Case\Repositories\CaseRepository;
use Modules\Case\Repositories\Criteria\CasePageCriteria;

class CasePageController extends Controller
{
    public function __construct(
        protected CaseRepository $caseRepository
    ) {
        $this->caseRepository->resetCriteria();
    }

    public function index()
    {
        $contacts = $this->caseRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug', 'image', 'short_description', 'published_at')
                    ;
            })
            ->with(['city' => function ($query) {
                $query->addSelect('id', 'name');
            }])
            ->orderBy('name', 'asc')
            ->findWhere([
                'status' => Status::ACTIVE,
            ])
            ->all();

        return CasePageResource::collection($contacts);
    }

    public function show(string $case)
    {
        $case = $this->caseRepository
            ->pushCriteria(CasePageCriteria::class)
            ->findByField('slug', $case)
            ->first();

        return new CasePageResource($case);
    }
}

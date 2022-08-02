<?php


namespace Modules\Case\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Case\Repositories\CaseRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class CaseSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected CaseRepository $caseRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $case)
    {
        $case = $this->caseRepository
            ->skipCriteria()
            ->find($case);

        $this->authorize('update', $case);

        $seo = $this->seoStorage->update($case->seo(), new SeoDto($request->validated()));

        return new SeoResource($seo);
    }
}

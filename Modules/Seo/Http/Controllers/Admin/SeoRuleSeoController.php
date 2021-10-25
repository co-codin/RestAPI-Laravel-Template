<?php


namespace Modules\Seo\Http\Controllers\Admin;


use Modules\Brand\Repositories\BrandRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Repositories\SeoRuleRepository;
use Modules\Seo\Services\SeoStorage;
use Illuminate\Routing\Controller;

class SeoRuleSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected SeoRuleRepository $seoRuleRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $seo_rule)
    {
        $seoRule = $this->seoRuleRepository->skipCriteria()->find($seo_rule);

        $seo = $this->seoStorage->update(
            $seoRule->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

<?php

namespace Modules\Seo\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Seo\Dto\SeoRuleDto;
use Modules\Seo\Http\Requests\Admin\SeoRuleCreateRequest;
use Modules\Seo\Http\Requests\Admin\SeoRuleUpdateRequest;
use Modules\Seo\Http\Resources\SeoRuleResource;
use Modules\Seo\Repositories\SeoRuleRepository;
use Modules\Seo\Services\SeoRuleStorage;

class SeoRuleController extends Controller
{
    public function __construct(
        protected SeoRuleRepository $seoRuleRepository,
        protected SeoRuleStorage $seoRuleStorage
    ) {}

    public function store(SeoRuleCreateRequest $request)
    {
        $seoRule = $this->seoRuleStorage->store(SeoRuleDto::fromFormRequest($request));

        return new SeoRuleResource($seoRule);
    }

    public function update(int $seo_rule, SeoRuleUpdateRequest $request)
    {
        $seoRuleModel = $this->seoRuleRepository->find($seo_rule);

        $seoRuleModel = $this->seoRuleStorage->update($seoRuleModel, (new SeoRuleDto($request->validated()))->only(...$request->keys()));

        return new SeoRuleResource($seoRuleModel);
    }

    public function destroy(int $seo_rule)
    {
        $seoRule = $this->seoRuleRepository->find($seo_rule);

        $this->seoRuleStorage->delete($seoRule);

        return response()->noContent();
    }
}

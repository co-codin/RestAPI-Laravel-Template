<?php

namespace Modules\Seo\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Seo\Dto\SeoRuleDto;
use Modules\Seo\Http\Requests\SeoRuleCreateRequest;
use Modules\Seo\Http\Requests\SeoRuleUpdateRequest;
use Modules\Seo\Http\Resources\SeoRuleResource;
use Modules\Seo\Repositories\SeoRuleRepository;
use Modules\Seo\Services\SeoRuleStorage;

class SeoRuleController extends Controller
{
    public function __construct(
        protected SeoRuleRepository $seoRuleRepository,
        protected SeoRuleStorage $seoRuleStorage
    ) {}

    public function index()
    {
        $seoRules = $this->seoRuleRepository->jsonPaginate();

        return SeoRuleResource::collection($seoRules);
    }

    public function show(int $seo_rule)
    {
        $seoRuleModel = $this->seoRuleRepository->find($seo_rule);

        return new SeoRuleResource($seoRuleModel);
    }

    public function store(SeoRuleCreateRequest $request)
    {
        $seoRule = $this->seoRuleStorage->store(SeoRuleDto::fromFormRequest($request));

        return new SeoRuleResource($seoRule);
    }

    public function update(int $seo_rule, SeoRuleUpdateRequest $request)
    {
        $seoRuleModel = $this->seoRuleRepository->find($seo_rule);

        $seoRuleModel = $this->seoRuleStorage->update($seoRuleModel, SeoRuleDto::fromFormRequest($request));

        return new SeoRuleResource($seoRuleModel);
    }

    public function destroy(int $seo_rule)
    {
        $seoRule = $this->seoRuleRepository->find($seo_rule);

        $this->seoRuleStorage->delete($seoRule);

        return response()->noContent();
    }
}

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
        $seoRuleDto = SeoRuleDto::fromFormRequest($request);

        if (!$seoRuleDto->assigned_by_id) {
            $seoRuleDto->assigned_by_id = auth('custom-token')->id();
        }

        $seoRule = $this->seoRuleStorage->store($seoRuleDto);

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

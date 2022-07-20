<?php

namespace Modules\Seo\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Seo\Dto\SeoRuleDto;
use Modules\Seo\Http\Requests\Admin\SeoRuleCreateRequest;
use Modules\Seo\Http\Requests\Admin\SeoRuleUpdateRequest;
use Modules\Seo\Http\Resources\SeoRuleResource;
use Modules\Seo\Models\SeoRule;
use Modules\Seo\Repositories\SeoRuleRepository;
use Modules\Seo\Services\SeoRuleStorage;

class SeoRuleController extends Controller
{
    public function __construct(
        protected SeoRuleStorage $seoRuleStorage,
        protected SeoRuleRepository $seoRuleRepository
    ) {}

    public function store(SeoRuleCreateRequest $request)
    {
        $this->authorize('create', SeoRule::class);

        $seoRuleDto = SeoRuleDto::fromFormRequest($request);

        if (!$seoRuleDto->assigned_by_id) {
            $seoRuleDto->assigned_by_id = auth('sanctum')->id();
        }

        $seoRule = $this->seoRuleStorage->store($seoRuleDto);

        return new SeoRuleResource($seoRule);
    }

    public function update(int $seo_rule, SeoRuleUpdateRequest $request)
    {
        $seo_rule = $this->seoRuleRepository->find($seo_rule);

        $this->authorize('update', $seo_rule);

        $seo_rule = $this->seoRuleStorage->update($seo_rule, (new SeoRuleDto($request->validated()))->only(...$request->keys()));

        return new SeoRuleResource($seo_rule);
    }

    public function destroy(int $seo_rule)
    {
        $seo_rule = $this->seoRuleRepository->find($seo_rule);

        $this->authorize('delete', $seo_rule);

        $this->seoRuleStorage->delete($seo_rule);

        return response()->noContent();
    }
}

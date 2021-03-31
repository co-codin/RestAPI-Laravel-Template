<?php

namespace Modules\Seo\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
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
        $seoRule = $this->seoRuleRepository->find($seo_rule);

        return new SeoRuleResource($seoRule);
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy(int $seo_rule)
    {
        $seoRule = $this->seoRuleRepository->find($seo_rule);

        $this->seoRuleStorage->delete($seoRule);

        return response()->noContent();
    }
}

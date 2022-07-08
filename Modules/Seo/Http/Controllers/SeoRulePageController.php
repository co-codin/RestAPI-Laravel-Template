<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Seo\Repositories\SeoRuleRepository;

class SeoRulePageController extends Controller
{
    public function __construct(
        protected SeoRuleRepository $seoRuleRepository
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
}

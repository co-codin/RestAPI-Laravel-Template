<?php

namespace Modules\Seo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seo\Http\Resources\SeoRuleResource;
use Modules\Seo\Repositories\SeoRuleRepository;

class SeoRuleController extends Controller
{
    public function __construct(
        protected SeoRuleRepository $seoRuleRepository
    ) {}

    public function index()
    {
        $seoRules = $this->seoRuleRepository->jsonPaginate();

        return SeoRuleResource::collection($seoRules);
    }

    public function show(string $url)
    {
        $seoRule = $this->seoRuleRepository->findByUrl($url);

        return new SeoRuleResource($seoRule);
    }
}

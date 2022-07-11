<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Seo\Http\Resources\SeoRulePageResource;
use Modules\Seo\Repositories\SeoRuleRepository;

class SeoRulePageController extends Controller
{
    public function __construct(
        protected SeoRuleRepository $seoRuleRepository
    ) {
        $this->seoRuleRepository->resetCriteria();
    }

    public function index()
    {
    }

    public function show(string $seo_rule)
    {
        $seoRule = $this->seoRuleRepository
            ->scopeQuery(function ($query) {
                return $query->addSelect('text');
            })
            ->findWhere([
                'url' => "/{$seo_rule}"
            ])
            ->first()
            ;

        return new SeoRulePageResource($seoRule);
    }
}

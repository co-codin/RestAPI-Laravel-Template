<?php


namespace Modules\Seo\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Models\SeoRule;
use Modules\Seo\Services\SeoStorage;

class SeoRuleSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
    ) {}

    public function update(SeoUpdateRequest $request, SeoRule $seo_rule)
    {
        $this->authorize('update', $seo_rule);

        $seo = $this->seoStorage->update(
            $seo_rule->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

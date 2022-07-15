<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Models\Brand;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class BrandSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage
    ) {}

    public function update(SeoUpdateRequest $request, Brand $brand)
    {
        $this->authorize('updateSeo', $brand);

        $seo = $this->seoStorage->update(
            $brand->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

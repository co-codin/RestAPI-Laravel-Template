<?php


namespace Modules\Brand\Http\Controllers\Admin;


use Modules\Brand\Repositories\BrandRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;
use Illuminate\Routing\Controller;

class BrandSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected BrandRepository $brandRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $brand)
    {
        $brand = $this->brandRepository->skipCriteria()->find($brand);

        $seo = $this->seoStorage->update(
            $brand->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

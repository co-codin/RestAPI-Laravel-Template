<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Repositories\ProductRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class ProductSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected ProductRepository $productRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $product)
    {
        $product = $this->productRepository->skipCriteria()->find($product);

        $seo = $this->seoStorage->update(
            $product->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

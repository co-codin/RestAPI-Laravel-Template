<?php


namespace Modules\Category\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class CategorySeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected CategoryRepository $categoryRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $category)
    {
        $category = $this->categoryRepository->skipCriteria()->find($category);

        $seo = $this->seoStorage->update(
            $category->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

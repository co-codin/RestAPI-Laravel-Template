<?php


namespace Modules\Category\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
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
        $relation = $request->input('type') == 2
            ? $category->seoCategoryProducts()
            : $category->seo();

        $seo = $this->seoStorage->update(
            $relation,
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}

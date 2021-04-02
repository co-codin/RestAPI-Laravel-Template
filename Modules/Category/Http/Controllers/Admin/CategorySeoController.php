<?php


namespace Modules\Category\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Enums\SeoType;
use Modules\Seo\Http\Requests\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class CategorySeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected CategoryRepository $categoryRepository,
    ) {}

    public function parentUpdate(SeoUpdateRequest $request, int $parent_category)
    {
        $parent_category = $this->categoryRepository->skipCriteria()->find($parent_category);

        if ($parent_category->seo->type === SeoType::Self) {
            $seo = $this->seoStorage->update(
                $parent_category->seo(),
                new SeoDto($request->validated())
            );

            return new SeoResource($seo);
        }
    }

    public function childUpdate(SeoUpdateRequest $request, int $child_category)
    {
        $child_category = $this->categoryRepository->skipCriteria()->find($child_category);

        if ($child_category->seo->type === SeoType::Children) {
            $seo = $this->seoStorage->update(
                $child_category->seo(),
                new SeoDto($request->validated())
            );

            return new SeoResource($seo);
        }
    }
}

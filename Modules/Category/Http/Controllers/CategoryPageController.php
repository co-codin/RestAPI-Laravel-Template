<?php

namespace Modules\Category\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Category\Http\Resources\CategoryPageResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\Criteria\CategoryPageCriteria;
use Modules\Category\Services\CategoryBrandsField;
use Modules\Product\Models\ProductCategory;

class CategoryPageController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository->resetCriteria();
    }

    public function index()
    {
        $categories = $this->categoryRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'image', 'slug', 'parent_id')
                    ->withCount('products AS productCount')
                    ;
            })
            ->orderBy('name','asc')
            ->findWhere([
                'status' => Status::ACTIVE,
            ])
            ->all()
        ;

        return CategoryPageResource::collection($categories);
    }

    public function show(string $category)
    {
        $category = $this->categoryRepository
            ->pushCriteria(CategoryPageCriteria::class)
            ->findByField('slug', $category)
            ->first();


        $cls = new CategoryBrandsField;
        $category->brands = $cls($category);

        return new CategoryPageResource($category);
    }

    public function getRootCategoriesByProductIds()
    {
        $productIds = request()->get('ids');


        $categories = ProductCategory::query()
            ->with([
                'category' => fn($query) => $query->select('id', '_lft', '_rgt'),
                'category.ancestors' => fn($query) => $query->select('id', 'name', '_lft', '_rgt')->whereNull('parent_id'),
            ])
            ->whereIn('product_id', $productIds)
            ->where('is_main', true)
            ->get()
            ->map(fn($productCategory) => $productCategory->category->ancestors->first())
            ->groupBy('id')
            ->map(function($group) {
                $category = $group->first();
                $category->count = $group->count();
                return $category;
            })
            ->values();

        return CategoryPageResource::collection($categories);
    }

    public function getCategoriesByProductIds()
    {
        $productIds = request()->get('ids');

        $categories = ProductCategory::query()
            ->with([
                'category' => fn($query) => $query->select('id', 'name'),
            ])
            ->whereIn('product_id', $productIds)
            ->where('is_main', true)
            ->get()
            ->map(fn($productCategory) => $productCategory->category)
            ->groupBy('id')
            ->map(function($group) {
                $category = $group->first();
                $category->count = $group->count();
                return $category;
            })
            ->values();

        return CategoryPageResource::collection($categories);
    }
}

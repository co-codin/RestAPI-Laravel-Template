<?php

namespace Modules\Category\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Category\Http\Resources\CategoryPageResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\Criteria\CategoryPageCriteria;
use Modules\Category\Services\CategoryBrandsField;

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
}

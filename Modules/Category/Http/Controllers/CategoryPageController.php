<?php

namespace Modules\Category\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Category\Http\Resources\CategoryPageResource;
use Modules\Category\Repositories\CategoryRepository;
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
            ->scopeQuery(function ($query) use ($category) {
                return $query
                    ->addSelect('id', 'name', 'slug', 'image', 'full_description', 'parent_id', '_lft', '_rgt')
                ;
            })
            ->with([
                'ancestors' => function ($query) {
                    $query->addSelect('id', 'parent_id', 'name', 'slug', '_lft', '_rgt');
                }
            ])
            ->with([
                'descendants' => function ($query) {
                    $query->addSelect('id', 'parent_id', '_lft', '_rgt');
                }
            ])
            ->with([
                'children' => function ($query) {
                    $query->addSelect('id', 'name', 'slug', 'image', 'status', '_lft', 'parent_id', '_lft', '_rgt');
                }
            ])
            ->with(['seo' => function ($query) {
                $query->addSelect('seoable_id', 'title', 'description', 'h1', 'is_enabled');
            }])
            ->with([
                'filters' => function ($query) {
                    $query->with(['property' => function ($query) {
                        $query->addSelect('id', 'key');
                    }]);
                }
            ])
            ->findByField('slug', $category)
            ->first();


        $cls = new CategoryBrandsField;
        $category->brands = $cls($category);

        return new CategoryPageResource($category);
    }
}

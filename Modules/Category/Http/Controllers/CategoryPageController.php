<?php

namespace Modules\Category\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Category\Http\Resources\CategoryPageResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\Criteria\CategoryPageCriteria;

class CategoryPageController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

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
            ->scopeQuery(function ($query) {
                return $query->addSelect(
                    'id', 'name', 'slug', 'image',
                    'full_description',

                );
            })
            ->with([
                'ancestors' => function ($query) {
                    $query->addSelect('id', 'name', 'slug', '_lft');
                }
            ])
            ->with([
                'descendants' => function ($query) {
                    $query->addSelect('id');
                }
            ])
            ->with([
                'children' => function ($query) {
                    $query->addSelect('id', 'name', 'slug', 'image', 'status', '_lft');
                }
            ])
            ->with(['seo' => function ($query) {
                $query->addSelect('seoable_id', 'title', 'description', 'h1', 'is_enabled');
            }])
            ->with(['brands' => function ($query) {
                $query->addSelect('id', 'name', 'slug');
            }])

            ->findByField('slug', $category)

            ;

        return new CategoryPageResource($category);
    }
}

<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\ActiveStatusCriteria;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Services\CategoryStorage;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected CategoryStorage $categoryStorage
    ) {
        $this->categoryRepository->popCriteria(ActiveStatusCriteria::class);
    }

    public function index()
    {
        $categories = $this->categoryRepository->jsonPaginate();

        return CategoryResource::collection($categories);
    }

    public function show(int $category)
    {
        $categoryModel = $this->categoryRepository->find($category);

        return new CategoryResource($categoryModel);
    }


}

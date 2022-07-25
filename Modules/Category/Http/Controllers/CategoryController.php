<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

    public function all()
    {
        $categories = $this->categoryRepository->all();

        return CategoryResource::collection($categories);
    }

    public function index()
    {
        $categories = $this->categoryRepository->jsonPaginate();

        return CategoryResource::collection($categories);
    }

    public function show(int $category)
    {
        $category = $this->categoryRepository->find($category);

        return new CategoryResource($category);
    }
}

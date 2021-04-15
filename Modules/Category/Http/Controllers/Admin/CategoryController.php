<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Category\Dto\CategoryDto;
use Modules\Category\Http\Requests\CategoryCreateRequest;
use Modules\Category\Http\Requests\CategoryUpdateRequest;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Services\CategoryStorage;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected CategoryStorage $categoryStorage
    ) {}

    public function store(CategoryCreateRequest $request)
    {
        $category = $this->categoryStorage->store(CategoryDto::fromFormRequest($request));

        return new CategoryResource($category);
    }

    public function update(int $category, CategoryUpdateRequest $request)
    {
        $categoryModel = $this->categoryRepository->find($category);

        $categoryModel = $this->categoryStorage->update($categoryModel, (new CategoryDto($request->validated()))->only(...$request->keys()));

        return new CategoryResource($categoryModel);
    }

    public function destroy(int $category)
    {
        $categoryModel = $this->categoryRepository->find($category);

        $this->categoryStorage->delete($categoryModel);

        return response()->noContent();
    }
}

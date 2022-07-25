<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Category\Dto\CategoryDto;
use Modules\Category\Http\Requests\CategoryCreateRequest;
use Modules\Category\Http\Requests\CategoryUpdateRequest;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Services\CategoryStorage;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryStorage $categoryStorage,
        protected CategoryRepository $categoryRepository
    ) {}

    public function store(CategoryCreateRequest $request)
    {
        $this->authorize('create', Category::class);

        $categoryDto = CategoryDto::fromFormRequest($request);

        if (!$categoryDto->assigned_by_id) {
            $categoryDto->assigned_by_id = auth('sanctum')->id();
        }

        $category = $this->categoryStorage->store($categoryDto);

        return new CategoryResource($category);
    }

    public function update(int $category, CategoryUpdateRequest $request)
    {
        $category = $this->categoryRepository->find($category);

        $this->authorize('update', $category);

        $category = $this->categoryStorage->update(
            $category, CategoryDto::fromFormRequest($request)
        );

        return new CategoryResource($category);
    }

    public function destroy(int $category)
    {
        $category = $this->categoryRepository->find($category);

        $this->authorize('delete', $category);

        $this->categoryStorage->delete($category);

        return response()->noContent();
    }
}

<?php


namespace Modules\Category\Services;


use Modules\Category\Dto\CategoryDto;
use Modules\Category\Models\Category;

class CategoryStorage
{
    public function store(CategoryDto $categoryDto)
    {
        $category = new Category($categoryDto->toArray());

        if (!$category->save()) {
            throw new \LogicException('can not create category');
        }

        return $category;
    }

    public function update(Category $category, CategoryDto $categoryDto)
    {
        if (!$category->update($categoryDto->toArray())) {
            throw new \LogicException('can not update category');
        }

        return $category;
    }

    public function delete(Category $category)
    {
        if (!$category->delete()) {
            throw new \LogicException('can not delete category');
        }
    }
}

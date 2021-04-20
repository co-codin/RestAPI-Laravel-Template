<?php


namespace Modules\Category\Services;


use App\Services\File\ImageUploader;
use Modules\Category\Dto\CategoryDto;
use Modules\Category\Models\Category;

class CategoryStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(CategoryDto $categoryDto)
    {
        $attributes = $categoryDto->toArray();

        if($categoryDto->image) {
            $attributes['image'] = $this->imageUploader->upload($categoryDto->image);
        }

        return Category::query()->create($attributes);
    }

    public function update(Category $category, CategoryDto $categoryDto)
    {
        $attributes = $categoryDto->toArray();

        if($categoryDto->image) {
            $attributes['image'] = $this->imageUploader->upload($categoryDto->image);
        }

        if (!$category->update($attributes)) {
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

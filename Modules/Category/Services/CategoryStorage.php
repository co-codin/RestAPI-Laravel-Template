<?php


namespace Modules\Category\Services;


use Modules\Category\Dto\CategoryDto;
use Modules\Category\Events\CategorySaved;
use Modules\Category\Models\Category;
use Modules\Filter\Repositories\FilterRepository;
use Modules\Filter\Services\FilterStorage;

class CategoryStorage
{
    public function __construct(
        protected FilterRepository $filterRepository
    ) {}

    public function store(CategoryDto $categoryDto)
    {
        $attributes = $categoryDto->toArray();

        // default value of review criteria
        $attributes['review_ratings'] = [
            ['name' => 'Общая оценка'],
        ];

        $category = Category::query()->create($attributes);

        event(new CategorySaved($category));

        if ($categoryDto->attach_default_filters) {
            FilterStorage::linkToDefaultFilters($this->filterRepository->findDefaultFilters(), $category->id);
        }

        return $category;
    }

    public function update(Category $category, CategoryDto $categoryDto)
    {
        $attributes = $categoryDto->toArray();

        if (!$category->update($attributes)) {
            throw new \LogicException('can not update category');
        }

        event(new CategorySaved($category));

        return $category;
    }

    public function delete(Category $category)
    {
        if (!$category->delete()) {
            throw new \LogicException('can not delete category');
        }
    }
}

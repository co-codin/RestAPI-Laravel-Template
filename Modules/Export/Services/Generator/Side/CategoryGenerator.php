<?php


namespace Modules\Export\Services\Generator\Side;


class CategoryGenerator
{
    public function getCategories(): array
    {
        $categories = [];

        foreach ($this->getCategoryEntities() as $category) {
            $categories[] = (new CategoryYaml())
                ->setId($category->id)
                ->setParentId($category->parent_id)
                ->setName($category->title);
        }

        return $categories;
    }

    private function getCategoryEntities(): Collection
    {
        return Category::query()
            ->defaultOrder()
            ->whereStatus(Status::Active)
            ->get();
    }
}

<?php


namespace Modules\Export\Services\Generators\Tiu\Entities;

use App\Enums\Status;
use Bukashk0zzz\YmlGenerator\Model\Category as CategoryYaml;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;


class CategoryGenerator
{
    public function getCategories(): array
    {
        $categories = [];
        $categoryEntities = $this->getCategoryEntities();

        foreach ($categoryEntities as $category) {
            $categories[] = (new CategoryYaml())
                ->setId($category->id)
                ->setParentId($category->parent_id)
                ->setName($category->name);
        }

        return $categories;
    }

    private function getCategoryEntities(): Collection
    {
        return Category::query()
            ->defaultOrder()
            ->whereStatus(Status::ACTIVE)
            ->get();
    }
}

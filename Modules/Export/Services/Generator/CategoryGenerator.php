<?php


namespace Modules\Export\Services\Generator;

use App\Enums\Status;
use Bukashk0zzz\YmlGenerator\Model\Category as CategoryYaml;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;


class CategoryGenerator
{
    public function getCategories(): array
    {
        $categories = [];

        foreach ($this->getCategoryEntities() as $category) {
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

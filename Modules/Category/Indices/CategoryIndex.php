<?php

namespace Modules\Category\Indices;

use Modules\Category\Http\Resources\Index\CategorySearchResource;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Search\Services\BaseIndex;

class CategoryIndex extends BaseIndex
{
    public function name(): string
    {
        return (new Category())->getSearchIndex();
    }

    public function repository(): string
    {
        return CategoryRepository::class;
    }

    public function resource(): string
    {
        return CategorySearchResource::class;
    }

    public function settings(): array
    {
        return [
            'number_of_shards' => 2,
            'number_of_replicas' => 0,
            'index' => [
                'max_ngram_diff' => 10
            ],
        ];
    }

    public function mappings(): array
    {
        return [
            'properties' => [
                'slug' => [
                    'type' => 'keyword',
                ],
            ],
        ];
    }

}

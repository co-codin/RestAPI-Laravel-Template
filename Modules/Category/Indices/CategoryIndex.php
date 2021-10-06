<?php

namespace Modules\Category\Indices;

use Modules\Category\Http\Resources\Index\CategorySearchResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Search\Services\BaseIndex;

class CategoryIndex extends BaseIndex
{
    public function name(): string
    {
        return "categories_v2";
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
                'name' => [
                    'type' => 'text',
                    'fields' => [
                        'with_ru_en' => [
                            'type' => 'text',
                            'analyzer' => 'ru_RU_index_char',
                            'search_analyzer' => 'ru_RU_search_char'
                        ],
                        'without_ru_en' => [
                            'type' => 'text',
                            'analyzer' => 'ru_RU_index',
                            'search_analyzer' => 'ru_RU_search'
                        ],
                        'shingle' => [
                            'type' => 'text',
                            'analyzer' => 'shingle',
                        ],
                        'phonetic' => [
                            'type' => 'text',
                            'analyzer' => 'phonetic',
                        ],
                    ],
                ],
                'slug' => [
                    'type' => 'keyword',
                ],
            ],
        ];
    }

}

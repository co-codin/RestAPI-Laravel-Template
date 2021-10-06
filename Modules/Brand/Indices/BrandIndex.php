<?php

namespace Modules\Brand\Indices;

use Modules\Brand\Http\Resources\Index\BrandSearchResource;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Search\Services\BaseIndex;

class BrandIndex extends BaseIndex
{
    public function name(): string
    {
        return "brands_v2";
    }

    public function repository(): string
    {
        return BrandRepository::class;
    }

    public function resource(): string
    {
        return BrandSearchResource::class;
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
                        'without_ru_en' => [
                            'type' => 'text',
                            'analyzer' => 'en_US_ru_RU_index',
                            'search_analyzer' => 'en_US_ru_RU_search'
                        ],
                        'with_ru_en' => [
                            'type' => 'text',
                            'analyzer' => 'en_US_ru_RU_index_char',
                            'search_analyzer' => 'en_US_ru_RU_search_char'
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

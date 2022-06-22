<?php

namespace Modules\Brand\Indices;

use Modules\Brand\Http\Resources\Index\BrandSearchResource;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Search\Services\BaseIndex;

class BrandIndex extends BaseIndex
{
    public function name(): string
    {
        return (new Brand())->getSearchIndex();
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
                'slug' => [
                    'type' => 'keyword',
                ],
            ],
        ];
    }

}

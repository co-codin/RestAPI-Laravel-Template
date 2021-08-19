<?php

namespace Modules\Product\Indices;

use Modules\Product\Http\Resources\Index\ProductSearchResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Contracts\SearchIndex;
use Modules\Search\Services\BaseIndex;

class ProductIndex extends BaseIndex implements SearchIndex
{
    public function name(): string
    {
        return "products";
    }

    public function repository(): string
    {
        return ProductRepository::class;
    }

    public function resource(): string
    {
        return ProductSearchResource::class;
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
                'id' => [
                    'type' => 'integer',
                ],
                'name' => [
                    'type' => 'keyword',
                ],
                'slug' => [
                    'type' => 'keyword',
                ],
                'status' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
                'warranty' => [
                    'type' => 'integer',
                ],
                'brand' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'country' => [
                            'type' => 'keyword',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'category' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'properties' => [
                    'type' => 'nested',
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'keyword',
                        ],
                        'value_numeric' => [
                            'type' => 'float',
                        ],
                    ],
                ],
            ],
        ];
    }
}

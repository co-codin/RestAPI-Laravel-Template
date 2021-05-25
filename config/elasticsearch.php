<?php

return [
    'enabled' => env('ELASTICSEARCH_ENABLED', true),
    'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
    'index_prefix' => env('ELASTICSEARCH_INDEX_PREFIX'),
    'indices' => [
        \Modules\Product\Models\Product::class => [
            'repository' => \Modules\Product\Repositories\ProductRepository::class,
            'settings' => [
                'number_of_shards' => 2,
                'number_of_replicas' => 0,
                'index' => [
                    'max_ngram_diff' => 10
                ],
            ],
            'mappings' => [
                'properties' => [
                    'name' => [
                        'type' => 'text',
                    ],
                    'slug' => [
                        'type' => 'keyword',
                    ],
                    'status' => [
                        'properties' => [
                            'key' => [
                                'type' => 'integer',
                            ],
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'title' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                    'brand' => [
                        'properties' => [
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'country' => [
                                'type' => 'keyword',
                            ],
                            'name' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                    'categories' => [
                        'type' => 'nested',
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'name' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                    'productVariations' => [
                        'type' => 'nested',
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'price' => [
                                'type' => 'integer',
                            ],
                            'previous_price' => [
                                'type' => 'integer',
                            ],
                            'is_price_visible' => [
                                'type' => 'integer',
                            ],
                            'is_in_stock' => [
                                'type' => 'integer',
                            ],
                            'stock_type' => [
                                'type' => 'keyword',
                            ],
                            'availability' => [
                                'properties' => [
                                    'slug' => [
                                        'type' => 'keyword',
                                    ],
                                    'title' => [
                                        'type' => 'keyword',
                                    ],
                                ]
                            ],
                        ]
                    ],
                    'properties' => [
                        'type' => 'nested',
                        'properties' => [
                            'key' => [
                                'type' => 'integer',
                            ],
                            'name' => [
                                'type' => 'keyword',
                            ],
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'slug_number' => [
                                'type' => 'integer',
                            ],
                            'value' => [
                                'type' => 'keyword',
                            ],
                            'aggregation' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                ],
            ]
        ]
    ]
];

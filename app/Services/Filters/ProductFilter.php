<?php


namespace App\Services\Filters;


use Modules\Category\Models\Category;
use Modules\Filter\Repositories\FilterRepository;
use Modules\Product\Repositories\ProductRepository;

class ProductFilter
{
    protected $category;

    protected $filters;

    const DEFAULT_SORT = 'popular';

    protected array $availableSort = [
        'price' => [
            'productVariations.is_in_stock' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                ]
            ],
            'productVariations.is_price_visible' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                ]
            ],
            'productVariations.price_in_rub' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                    'filter' => [
                        'range' => [
                            'productVariations.price_in_rub' => [
                                'gt' => 0,
                            ]
                        ],
                    ],
                ]
            ],
        ],
        '-price' => [
            'productVariations.is_in_stock' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'variations',
                ]
            ],
            'productVariations.is_price_visible' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                ]
            ],
            'productVariations.price_in_rub' => [
                'order' => 'desc',
                'mode' => 'min',
                'nested' => [
                    'path' => 'productVariations',
                    'filter' => [
                        'range' => [
                            'productVariations.price_in_rub' => [
                                'gt' => 0,
                            ]
                        ],
                    ],
                ]
            ],
        ],
        'popular' => [
            'productVariations.is_in_stock' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                ]
            ],
            'productVariations.popular_score' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                ]
            ],
            'productVariations.is_price_visible' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                ]
            ],
            'productVariations.price_in_rub' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'productVariations',
                    'filter' => [
                        'range' => [
                            'productVariations.price_in_rub' => [
                                'gt' => 0,
                            ]
                        ],
                    ],
                ]
            ],
        ],
    ];

    public function __construct(
        protected ProductRepository $productRepository,
        protected FilterRepository $filterRepository
    ) {}

    public function setCategory(?Category $category = null) : self
    {
        $this->category = $category;

        return $this;
    }

    public function setFilters(FilterCollection $filters) : self
    {
        $this->filters = $filters;

        return $this;
    }
}

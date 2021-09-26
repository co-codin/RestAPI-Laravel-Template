<?php

namespace Modules\Product\Services;

use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Filter\Collections\FilterCollection;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Collections\FilteredCollection;

class ProductFilter
{
    protected FilterCollection $filters;

    protected FilterCollection $defaultFilters;

    protected int $page = 1;

    protected int $size = 15;

    protected string $sort = 'popular';

    public function __construct(
        protected Client $elasticsearch,
        protected ProductRepository $productRepository,
    ) {}

    public function getItems(): FilteredCollection
    {
        $result = $this->search();

        $ids = Arr::pluck(Arr::get($result, 'hits.hits', []), '_id');

        return new FilteredCollection(
            $this->getProducts($ids),
            $result
        );
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setSort(string $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function setSize(int $limit): self
    {
        $this->size = $limit;

        return $this;
    }

    public function availableSorts(): array
    {
        return [
            'price' => [
                'variations.in_stock_sort_value' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                    ]
                ],
                'variations.price_in_rub' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                        'filter' => [
                            'range' => [
                                'variations.price_in_rub' => [
                                    'gt' => 0,
                                ]
                            ],
                        ],
                    ]
                ],
                'slug' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                        'filter' => [
                            'range' => [
                                'variations.price_in_rub' => [
                                    'lte' => 0,
                                ]
                            ],
                        ],
                    ]
                ],
            ],
            '-price' => [
                'variations.in_stock_sort_value' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                    ]
                ],
                'variations.price_in_rub' => [
                    'order' => 'desc',
                    'mode' => 'min',
                    'nested' => [
                        'path' => 'variations',
                        'filter' => [
                            'range' => [
                                'variations.price_in_rub' => [
                                    'gt' => 0,
                                ]
                            ],
                        ],
                    ]
                ],
                'slug' => [
                    'order' => 'desc',
                    'nested' => [
                        'path' => 'variations',
                        'filter' => [
                            'range' => [
                                'variations.price_in_rub' => [
                                    'lte' => 0,
                                ]
                            ],
                        ],
                    ]
                ],
            ],
            'popular' => [
                'variations.in_stock_sort_value' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                    ]
                ],
                'variations.popular_score' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                    ]
                ],
                'variations.is_show_price' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                    ]
                ],
                'variations.price_in_rub' => [
                    'order' => 'asc',
                    'nested' => [
                        'path' => 'variations',
                        'filter' => [
                            'range' => [
                                'variations.price_in_rub' => [
                                    'gt' => 0,
                                ]
                            ],
                        ],
                    ]
                ],
            ],
        ];
    }

    protected function getBody(): array
    {
        $body = [
            'size' => $this->size,
            'from' => ($this->page - 1) * $this->size,
            'stored_fields' => [],
            'query' => $this->getQuery(),
//            'aggs' => $this->getAggregations(),
        ];

        if($this->sort && $this->isAvailableSort($this->sort)) {
//            $body['sort'] = $this->availableSorts()[$this->sort];
        }

        return $body;
    }

    protected function getQuery() : array
    {
        $filters = $this->defaultFilters
            ->merge($this->filters->enabled());

        return [
            'bool' => [
                'must' => $filters->getQuery(),
            ],
        ];
    }

    protected function getAggregations() : ? array
    {
        return [
            'aggregations' => [
                'global' => (object) [],
                'aggs' => [
                    'filtered' => [
                        'filter' => [
                            'bool' => [
                                'filter' => $this->defaultFilters->getQuery(),
                            ],
                        ],
                        'aggs' => $this->filters->getAggregations(),
                    ],
                ],
            ]
        ];
    }

    protected function isAvailableSort(string $sort): bool
    {
        return array_key_exists($sort, $this->availableSorts());
    }

    protected function search(): array
    {
        return $this->elasticsearch->search([
            'index' => 'products_v2',
            'body' => $this->getBody(),
        ]);
    }

    public function getProducts(array $ids)
    {
        return $this
            ->productRepository
            ->scopeQuery(fn($builder) => $builder->whereIn('id', $ids))
            ->get()
            ->sortBy(fn($product) => array_search($product->getKey(), $ids));
    }

    public function setFilters(FilterCollection $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function setDefaultFilters(FilterCollection $defaultFilters): self
    {
        $this->defaultFilters = $defaultFilters;

        return $this;
    }
}

<?php

namespace Modules\Product\Services;

use Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Collections\FilteredCollection;

class ProductFilter
{
    protected Client $elasticsearch;

    protected Request $request;

    protected array $query = [];

    protected array $aggregations = [];

    protected int $page = 1;

    protected int $size = 25;

    protected string $sort = 'popular';

    protected ProductRepository $productRepository;

    public function __construct(
        Request $request,
        Client $elasticsearch,
        ProductRepository $productRepository,
    )
    {
        $this->elasticsearch = $elasticsearch;
        $this->productRepository = $productRepository;

        $this->setQuery($request->input('query') ?? []);
        $this->setAggregations($request->input('aggregations') ?? []);
        $this->setPage($request->input('page.number') ?? 1);
        $this->setSize($request->input('page.size') ?? 25);
        $this->setSort($request->input('sort') ?? 'popular');
    }

    public function getItems(): FilteredCollection
    {
        $result = $this->search();

        $ids = Arr::pluck(Arr::get($result, 'hits.hits', []), '_id');

        return new FilteredCollection(
            $this->getProducts($ids),
            $result
        );
    }

    public function setQuery(array $query = []): self
    {
        $this->query = $query;

        return $this;
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

    public function setSize(int $limit)
    {
        $this->size = $limit;

        return $this;
    }

    public function setAggregations(array $aggregations = []): self
    {
        $this->aggregations = $aggregations;

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

    protected function getRequestBody(): array
    {
        $body = [
            'size' => $this->size,
            'from' => ($this->page - 1) * $this->size,
            'stored_fields' => [],
        ];

        if($this->query) {
            $body['query'] = $this->query;
        }

        if($this->aggregations) {
            $body['aggs'] = $this->aggregations;
        }

        if($this->sort && $this->isAvailableSort($this->sort)) {
//            $body['sort'] = $this->sort;
        }

        return $body;
    }

    protected function isAvailableSort(string $sort)
    {
        return array_key_exists($sort, $this->availableSorts());
    }

    protected function search(): array
    {
        return $this->elasticsearch->search([
            'index' => 'products',
            'body' => $this->getRequestBody(),
        ]);
    }

    public function getProducts(array $ids)
    {
        return $this
            ->productRepository
            ->findWhereIn('id', $ids)
            ->sortBy(function ($product) use ($ids) {
                return array_search($product->getKey(), $ids);
            })
            ->values();
    }
}

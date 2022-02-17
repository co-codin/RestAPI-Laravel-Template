<?php

namespace Modules\Product\Services;

use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Collections\FilteredCollection;

class ProductFilter
{
    protected int $page = 1;

    protected int $size = 15;

    protected string $sort = 'popular';

    protected Collection $filters;

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

    public function setFilters(array $filters): self
    {
        $this->filters = collect($filters);

        return $this;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setSize(int $limit): self
    {
        $this->size = $limit;

        return $this;
    }

    public function setSort(string $sort): ProductFilter
    {
        $this->sort = $sort;

        return $this;
    }

    protected array $availableSort = [
        'price' => [
            'availability_sort_value' => [
                'order' => 'asc',
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
            'availability_sort_value' => [
                'order' => 'asc',
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
            'group' => [
                'order' => 'asc',
                'missing' => '_last',
            ],
            'variations.availability' => [
                'order' => 'asc',
                'nested' => [
                    'path' => 'variations',
                ]
            ],
            'popular_score' => [
                'order' => 'asc',
            ],
            'variations.is_price_visible' => [
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
            'brand.name' => [
                'order' => 'asc',
            ],
            'name' => [
                'order' => 'asc',
            ],
        ],
    ];

    protected function getBody(): array
    {
        $body = [
            'size' => $this->size,
            'from' => ($this->page - 1) * $this->size,
            'stored_fields' => [],
            'query' => $this->getQuery(),
            'post_filter' => $this->getPostFilters(),
            'aggs' => $this->getAggregations(),
            'sort' => $this->getSort(),
        ];

        return $body;
    }

    protected function getQuery() : array
    {
        return $this->prepareFiltersQuery(
            $this->filters->where('is_default', true)
        );
    }

    protected function getPostFilters() : array
    {
        return $this->prepareFiltersQuery(
            $this->filters->where('is_default', false)
        );
    }

    protected function prepareFiltersQuery(Collection $filters): array
    {
        $mainFilters = $filters->whereNull('path')
            ->map(fn($filter) => $this->generateFacetsQuery($filter))
            ->values();

        $nestedFilters = $filters->whereNotNull('path')
            ->groupBy('path')
            ->map(function($filters, $path) {
                return [
                    "nested" => [
                        "path" => $path,
                        "query" => [
                            "bool" => [
                                "must" => $filters->map(fn($filter) => $this->generateFacetsQuery($filter))->toArray(),
                            ],
                        ],
                    ],
                ];
            })
            ->values();

        return [
            'bool' => [
                'must' => $mainFilters->merge($nestedFilters)->toArray(),
            ],
        ];
    }

    protected function generateFacetsQuery(array $filter): array
    {
        $prefix = ($filter['path'] ?? null) ? $filter['path'] . "." : null;
        $field = "facets";

        $value = Arr::wrap($filter['value']);

        if($filter['type'] == 'range') {
            $field = "numeric_facets";
            $value = [
                'gte' => $value['gte'] ?? 0,
                'lte' => $value['lte'] ?? 1,
            ];
        }

        return [
            "nested" => [
                "path" => $prefix . $field,
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "term" => [
                                    $prefix . "{$field}.name" => $filter['name'],
                                ],
                            ],
                            [
                                $filter['type'] => [
                                    $prefix . "{$field}.value" => $value,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getAggregations() : ? array
    {
        return [
            "facets" => [
                "nested" => [
                    "path" => "facets",
                ],
                "aggs" => [
                    "names" => [
                        "terms" => [
                            "field" => "facets.name",
                            "size" => 100,
                        ],
                        "aggs" => [
                            "values" => [
                                "terms" => [
                                    "field" => "facets.aggregation",
                                    "size" => 100,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            "numeric_facets" => [
                "nested" => [
                    "path" => "numeric_facets",
                ],
                "aggs" => [
                    "names" => [
                        "terms" => [
                            "field" => "numeric_facets.name",
                            "size" => 100,
                        ],
                        "aggs" => [
                            "values" => [
                                "stats" => [
                                    "field" => "numeric_facets.value",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'variations_facets' => [
                "nested" => [
                    "path" => "variations.facets",
                ],
                "aggs" => [
                    "names" => [
                        "terms" => [
                            "field" => "variations.facets.name",
                            "size" => 100,
                        ],
                        "aggs" => [
                            "values" => [
                                "terms" => [
                                    "field" => "variations.facets.aggregation",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'variations_numeric_facets' => [
                "nested" => [
                    "path" => "variations.numeric_facets",
                ],
                "aggs" => [
                    "names" => [
                        "terms" => [
                            "field" => "variations.numeric_facets.name",
                            "size" => 100,
                        ],
                        "aggs" => [
                            "values" => [
                                "stats" => [
                                    "field" => "variations.numeric_facets.value",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function search(): array
    {
        return $this->elasticsearch->search([
            'index' => (new Product)->getSearchIndex(),
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

    protected function getSort() : array
    {
        if(!$this->sort || !array_key_exists($this->sort, $this->availableSort)) {
            $this->sort = 'popular';
        }

        return $this->availableSort[$this->sort];
    }
}

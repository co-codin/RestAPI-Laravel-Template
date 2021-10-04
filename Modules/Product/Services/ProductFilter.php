<?php

namespace Modules\Product\Services;

use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Collections\FilteredCollection;

class ProductFilter
{
    protected int $page = 1;

    protected int $size = 15;

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

    protected function getBody(): array
    {
        $body = [
            'size' => $this->size,
            'from' => ($this->page - 1) * $this->size,
            'stored_fields' => [],
            'query' => $this->getQuery(),
            'post_filter' => $this->getPostFilters(),
            'aggs' => $this->getAggregations(),
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
                'gte' => $value[0] ?? 0,
                'lte' => $value[1] ?? 1,
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
                                    "field" => "facets.value",
                                    "size" => 100,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'numeric_facets' => [
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
        ray($this->getBody());

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
}

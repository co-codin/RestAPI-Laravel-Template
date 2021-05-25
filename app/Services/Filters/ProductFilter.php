<?php


namespace App\Services\Filters;


use App\Enums\Status;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Category\Models\Category;
use Modules\Filter\Collections\FilterCollection;
use Modules\Filter\Filters\NestedFilter;
use Modules\Filter\Filters\TermFilter;
use Modules\Filter\Models\Filter;
use Modules\Filter\Repositories\FilterRepository;
use Modules\Product\Models\Product;
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

    public function getProducts($perPage = 15) : LengthAwarePaginator
    {
        $products = $this->productRepository
            ->with([
                'productVariations',
                'productVariations.currency',
                'brand',
            ])
            ->findByQuery(
                $this->getQuery(),
                $this->getAggregations(),
                $perPage,
                $this->getSort()
            );

        $products->transform(function(Product $product) {
            return $product->present();
        });

        $this->getFilters()
            ->fillAggregations($products->getAggregations());

        return $products;
    }

    public function getFilters() : ? FilterCollection
    {
        if(is_null($this->filters) && $this->category) {
            $this->filters = $this->filterRepository
                ->findByCategoryId($this->category->id);
        }

        return $this->filters;
    }

    public function getNotEmptyFilters() : ? FilterCollection
    {
        if(is_null($filters = $this->getFilters())) {
            return null;
        }

        return $filters->filter(function(Filter $filter) {
            return $filter->isNotEmpty();
        });
    }

    protected function systemFilters() : FilterCollection
    {
        $filters = [
            new TermFilter('status.key', Status::ACTIVE),
            new NestedFilter('productVariations', [
                new TermFilter('productVariations.status.key', Status::ACTIVE),
            ]),
        ];

        if($this->category) {
            $filters[] = new NestedFilter('categories', [
                new TermFilter('categories.slug', $this->category->slug)
            ]);
        }

        return new FilterCollection($filters);
    }

    protected function getQuery() : array
    {
        $filters = $this->systemFilters()
            ->merge($this->getFilters()->enabled());

        return [
            'bool' => [
                'must' => $filters->getQuery(),
            ],
        ];
    }

    protected function getAggregations() : ? array
    {
        if(!$aggregations = $this->getFilters()->getAggregations()) {
            return null;
        }

        return [
            'aggregations' => [
                'global' => (object) [],
                'aggs' => [
                    'filtered' => [
                        'filter' => [
                            'bool' => [
                                'filter' => $this->systemFilters()->getQuery(),
                            ],
                        ],
                        'aggs' => $aggregations,
                    ],
                ],
            ]
        ];
    }

    protected function getSort() : array
    {
        $sort = request('sort');

        if(!$sort || !array_key_exists($sort, $this->availableSort)) {
            $sort = static::DEFAULT_SORT;
        }

        return $this->availableSort[$sort];
    }
}

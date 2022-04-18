<?php


namespace Modules\Search\Services;


use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class ProductSearchService extends SearchService
{
    public function __construct(
        protected ProductRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function getLiveSearchProducts(string $term, int $size = 10): ?array
    {
        $products = $this->getEntities($term, $size);

        return $products->map(function (Product $product) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => "{$product->category->product_name} {$product->brand->name} $product->name",
                'url' => $product->siteUrl,
                'type' => 'Товар',
                'image' => $product->image,
            ];
        })->toArray();
    }

    protected function getQuery(string $term): array
    {
        $fields = [
            'article^2',
            'full_name.with_ru_en',
            'full_name.without_ru_en',
            'full_name.shingle',
            'full_name',
        ];

        return [
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'fields' => $fields,
                        'query' => $term,
                        'type' => 'most_fields',
                        'fuzziness' => 'AUTO',
                        'operator' => 'and',
                        'prefix_length' => 2,
                        'minimum_should_match' => '70%',
                    ],
                ],
                "filter" => [
                    "term" => [
                        'status.id' => Status::ACTIVE
                    ]
                ]
            ]
//                'bool' => [
//                    'should' => [
//                        [
//                            'function_score' => [
//                                'query' => [
//                                    'multi_match' => [
//                                        'query' => $query,
//                                        'fields' => $fields,
//                                        'type' => 'most_fields',
//                                        'fuzziness' => 'AUTO',
//                                        'operator' => 'and',
//                                        'prefix_length' => 2,
//                                        'minimum_should_match' => '70%',
//                                    ],
//                                ],
//                                'min_score' => 0.5,
//                            ],
//                        ],
//                        [
//                            'function_score' => [
//                                'query' => [
//                                    'multi_match' => [
//                                        'query' => $query,
//                                        'fields' => ['full_name.phonetic'],
//                                        'fuzziness' => 'AUTO',
//                                        'operator' => 'and',
//                                        'prefix_length' => 2,
//                                    ],
//                                ],
//                                'min_score' => 15,
//                            ],
//                        ],
//                    ],
//                ],
        ];
    }

    /**
     * @return Product[]|Collection
     * @throws \Exception
     */
    public function getEntities(string $term, int $size = 10): Collection
    {
        $products = parent::getEntities($term, $size);
        return $products->load(['category', 'brand']);
    }

    /**
     * @param string $term
     * @param int $perPage
     * @return Product[]|LengthAwarePaginator
     * @throws \Exception
     */
    public function getProductsForSearchPage(string $term, int $perPage): LengthAwarePaginator
    {
        $query = $this->getQuery($term);

        return $this->repository->findByTerm($query, $perPage);
    }
}

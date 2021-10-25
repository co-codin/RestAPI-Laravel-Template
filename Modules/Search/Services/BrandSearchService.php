<?php


namespace Modules\Search\Services;


use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\BrandRepository;

/**
 * @method Brand[]|Collection getEntities(string $term, int $size = 1): Collection
 */
class BrandSearchService extends SearchService
{
    public function __construct(
        protected BrandRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function getLiveSearchBrands(string $term, int $size = 1): ?array
    {
        $brands = $this->getEntities($term, $size);

        return $brands->map(function (Brand $brand) {
            return [
                'id' => $brand->id,
                'slug' => $brand->slug,
                'name' => $brand->name,
                'url' => "/brands/$brand->slug",
                'type' => 'Производитель',
                'image' => $brand->image,
            ];
        })->toArray();
    }

    protected function getQuery(string $term): array
    {
        $fields = [
            'name.with_ru_en',
            'name.without_ru_en',
            'name.shingle',
            'name.phonetic',
            'name',
        ];

        return [
            'bool' => [
                'must' => [
                    'function_score' => [
                        'query' => [
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
                        'min_score' => 6
                    ],
                ],
                "filter" => [
                    "term" => [
                        'status.id' => Status::ACTIVE
                    ]
                ]
            ]
        ];

        return [
//            'function_score' => [
//                'query' => [
//                    'multi_match' => [
//                        'fields' => $fields,
//                        'query' => $term,
//                        'type' => 'most_fields',
//                        'fuzziness' => 'AUTO',
//                        'operator' => 'and',
//                        'prefix_length' => 2,
//                        'minimum_should_match' => '70%',
//                    ],
//                ],
//                'min_score' => 6
//            ],

//            'bool' => [
//                    'should' => [
//                        [
//                            'multi_match' => [
//                                'fields' => $fields,
//                                'query' => $term,
//                                'type' => 'most_fields',
//                                'fuzziness' => 'AUTO',
//                                'operator' => 'and',
//                                'prefix_length' => 2,
//                                'minimum_should_match' => '80%',
//                            ],
//                        ],
//                    ],
//                    'filter' => [
//                        [
//                            'term' => [
//                                'status.key' => Status::ACTIVE,
//                            ],
//                        ],
////                        [
////                            'term' => [
////                                'products_exist' => ProductSearchStatus::Exist,
////                            ],
////                        ]
//                    ],
//                    'minimum_should_match' => 1
//                ],
        ];
    }
}

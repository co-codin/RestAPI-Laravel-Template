<?php

namespace Tests\Feature\Modules\Geo\Gql;

use Modules\Geo\Models\SoldProduct;
use Tests\TestCase;

class SoldProductReadTest extends TestCase
{
    public function test_sold_products_can_be_viewed()
    {
        $soldProduct = SoldProduct::factory()->create();

        $response = $this->graphQL('
            {
                sold_products {
                    data {
                        id
                        title
                        product_id
                        city_id
                        category_id
                        type
                        status
                    }
                    paginatorInfo {
                        currentPage
                        lastPage
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'sold_products' => [
                    'data' => [
                        [
                            'id' => $soldProduct->id,
                            'title' => $soldProduct->title,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                sold_products(where: { column: ID, operator: EQ, value: ' . $soldProduct->id .'  }) {
                    data {
                        id
                        title
                        product_id
                        city_id
                        category_id
                        type
                        status
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'sold_products' => [
                    'data' => [
                        [
                            'id' => $soldProduct->id,
                            'title' => $soldProduct->title,
                        ]
                    ],
                ]
            ],
        ]);
    }
}

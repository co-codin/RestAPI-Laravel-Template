<?php

namespace Tests\Feature\Modules\Product\Gql;

use Modules\Product\Models\Product;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_products_can_be_viewed()
    {
        $product = Product::factory()->create();

        $response = $this->graphQL('
            {
                products {
                    data {
                        id
                        name
                        slug
                        brand {
                            id
                            name
                        }
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
                'products' => [
                    'data' => [
                        [
                            'id' => $product->id,
                            'name' => $product->name,
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
                products(where: { column: ID, operator: EQ, value: ' . $product->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'products' => [
                    'data' => [
                        [
                            'id' => $product->id,
                            'name' => $product->name,
                        ]
                    ],
                ]
            ],
        ]);
    }
}

<?php

namespace Tests\Feature\Modules\Product\Gql;

use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAnswer;
use Modules\Product\Models\ProductQuestion;
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

    public function test_product_questions_can_be_viewed(): void
    {
        $productQuestion = ProductQuestion::factory()->create();

        $response = $this->graphQL('
            {
                product_questions {
                    data {
                        id
                        product_id
                        client_id
                        status
                        text
                        product {
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
                'product_questions' => [
                    'data' => [
                        [
                            'id' => $productQuestion->id,
                            'product_id' => $productQuestion->product_id,
                            'client_id' => $productQuestion->client_id,
                            'status' => $productQuestion->status,
                            'text' => $productQuestion->text,
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
                product_questions(where: { column: ID, operator: EQ, value: ' . $productQuestion->id .'  }) {
                    data {
                        id
                        product_id
                        client_id
                        status
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'product_questions' => [
                    'data' => [
                        [
                            'id' => $productQuestion->id,
                            'name' => $productQuestion->name,
                            'product_id' => $productQuestion->product_id,
                            'client_id' => $productQuestion->client_id,
                            'status' => $productQuestion->status,
                        ]
                    ],
                ]
            ],
        ]);
    }

    public function test_product_answers_can_be_viewed(): void
    {
        $productAnswer = ProductAnswer::factory()->create();

        $response = $this->graphQL('
            {
                product_answers {
                    data {
                        id
                        product_question_id
                        text
                        first_name
                        last_name
                        productQuestion {
                            id
                            product_id
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
                'product_answers' => [
                    'data' => [
                        [
                            'id' => $productAnswer->id,
                            'product_question_id' => $productAnswer->product_question_id,
                            'text' => $productAnswer->text,
                            'first_name' => $productAnswer->first_name,
                            'last_name' => $productAnswer->last_name,
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
                product_answers(where: { column: ID, operator: EQ, value: ' . $productAnswer->id .'  }) {
                    data {
                        id
                        product_question_id
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'product_answers' => [
                    'data' => [
                        [
                            'id' => $productAnswer->id,
                            'product_question_id' => $productAnswer->product_question_id,
                        ]
                    ],
                ]
            ],
        ]);
    }
}

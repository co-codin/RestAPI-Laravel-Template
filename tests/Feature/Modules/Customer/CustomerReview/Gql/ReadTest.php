<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Gql;

use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_customer_reviews_can_be_viewed()
    {
        $customerReview = CustomerReview::factory()->create();

        $response = $this->graphQL('
            {
                customer_reviews {
                    data {
                        id
                        post
                        author
                        type
                        video
                        review_file
                        is_in_home
                        comment
                        logo
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
                'customer_reviews' => [
                    'data' => [
                        [
                            'id' => $customerReview->id,
                            'post' => $customerReview->post,
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
                customer_reviews(where: { column: ID, operator: EQ, value: ' . $customerReview->id .'  }) {
                    data {
                        id
                        post
                        author
                        type
                        video
                        review_file
                        is_in_home
                        comment
                        logo
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'customer_reviews' => [
                    'data' => [
                        [
                            'id' => $customerReview->id,
                            'post' => $customerReview->post,
                        ]
                    ],
                ]
            ],
        ]);

    }
}

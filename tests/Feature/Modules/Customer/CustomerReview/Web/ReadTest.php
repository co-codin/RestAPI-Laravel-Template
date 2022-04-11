<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Web;

use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;
use function route;

class ReadTest extends TestCase
{
    public function test_user_can_view_customer_reviews()
    {
        CustomerReview::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('customer-reviews.index'));

        $response->assertOk();
        $this->assertCount($count, ($response['data']));

        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "company_name",
                    "author",
                    "type",
                    "video",
                    "review_file",
                    "is_in_home",
                    "comment",
                    "logo",
                    "created_at",
                    "updated_at",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_user_can_view_single_customer_review()
    {
        $customerReview = CustomerReview::factory()->create();

        $response = $this->json('GET', route('customer-reviews.show', $customerReview));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "post",
                "author",
                "type",
                "video",
                "review_file",
                "is_in_home",
                "comment",
                "logo",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

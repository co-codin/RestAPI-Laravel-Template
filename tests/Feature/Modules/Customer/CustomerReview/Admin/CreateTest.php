<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Admin;

use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_customer_review()
//    {
//        //
//    }

    public function test_authenticated_can_create_customer_review()
    {
        $customerReviewData = CustomerReview::factory()->raw();

        $response = $this->json('POST', route('admin.customer-reviews.store'), $customerReviewData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'post',
                'author',
                'type',
                'video',
                'review_file',
                'is_in_home',
                'comment',
                'logo',
            ]
        ]);

        $this->assertDatabaseHas('customer_reviews', [
            'post' => $customerReviewData['post'],
            'author' => $customerReviewData['author'],
            'type' => $customerReviewData['type'],
            'video' => $customerReviewData['video'],
            'review_file' => $customerReviewData['review_file'],
            'is_in_home' => $customerReviewData['is_in_home'],
            'comment' => $customerReviewData['comment'],
            'logo' => $customerReviewData['logo'],
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Admin;

use Illuminate\Http\UploadedFile;
use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_customer_review()
    {
        $customerReviewData = CustomerReview::factory()->raw();

        $response = $this->json('POST', route('admin.customer-reviews.store'), $customerReviewData);

        $response->assertStatus(401);
    }

    public function test_authenticated_can_create_customer_review()
    {
        $this->authenticateUser();

        $customerReviewData = CustomerReview::factory()->raw([
            'logo' => UploadedFile::fake()->image('test.png'),
        ]);

        $response = $this->json('POST', route('admin.customer-reviews.store'), $customerReviewData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
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
            'author' => $customerReviewData['author'],
        ]);
    }
}

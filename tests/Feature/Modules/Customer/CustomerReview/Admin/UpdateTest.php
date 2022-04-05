<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Admin;

use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_customer_review()
    {
        $customerReview = CustomerReview::factory()->create();

        $response = $this->json('PATCH',
            route('admin.customer-reviews.update', $customerReview), [
                'post' => 'new post',
            ]
        );

        $response->assertStatus(401);
    }

    public function test_authenticated_can_update_customer_review()
    {
        $this->authenticateUser();

        $customerReview = CustomerReview::factory()->create();

        $response = $this->json('PATCH',
            route('admin.customer-reviews.update', $customerReview), [
                'company_name' => $newName = 'new post',
            ]
        );

        $response->assertOk();
        $this->assertDatabaseHas('customer_reviews', [
            'company_name' => $newName,
        ]);
    }
}

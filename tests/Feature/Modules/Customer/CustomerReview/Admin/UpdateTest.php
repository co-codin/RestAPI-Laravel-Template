<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Admin;

use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_customer_review()
//    {
//        //
//    }

    public function test_authenticated_can_update_customer_review()
    {
        $customerReview = CustomerReview::factory()->create();

        $response = $this->json('PATCH',
            route('admin.customer-reviews.update', $customerReview), [
                'post' => $newName = 'new post',
            ]
        );

        $response->assertOk();
        $this->assertDatabaseHas('customer_reviews', [
            'post' => $newName,
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Customer\CustomerReview\Admin;

use Modules\Customer\Models\CustomerReview;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_customer_review()
    {
        $this->authenticateUser();

        $customerReview = CustomerReview::factory()->create();

        $response = $this->json('DELETE', route('admin.customer-reviews.destroy', $customerReview));

        $response->assertNoContent();

        $this->assertDeleted($customerReview);
    }
}

<?php


namespace Tests\Feature\Modules\Attribute\Admin;

use Modules\Attribute\Models\Attribute;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_attribute()
    {
        $attribute = Attribute::factory()->create();

        $response = $this->deleteJson(route('admin.attributes.destroy', $attribute));

        $response->assertStatus(401);
    }

    public function test_authenticated_can_delete_attribute()
    {
        $this->authenticateUser();

        $attribute = Attribute::factory()->create();

        $response = $this->deleteJson(route('admin.attributes.destroy', $attribute));

        $response->assertNoContent();

        $this->assertSoftDeleted($attribute);
    }
}

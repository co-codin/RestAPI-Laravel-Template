<?php


namespace Tests\Feature\Modules\Category\Admin;

use Modules\Category\Models\Category;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson(route('admin.categories.destroy', $category));

        $response->assertStatus(401);
    }

    public function test_authenticated_can_delete_category()
    {
        $this->authenticateUser();

        $category = Category::factory()->create();

        $response = $this->deleteJson(route('admin.categories.destroy', $category));

        $response->assertNoContent();

        $this->assertSoftDeleted($category);
    }
}

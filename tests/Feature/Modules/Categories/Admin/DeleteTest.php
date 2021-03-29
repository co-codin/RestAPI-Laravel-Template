<?php


namespace Tests\Feature\Modules\Categories\Admin;

use Modules\Category\Models\Category;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_category()
    {
        //
    }

    public function test_authenticated_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->json('DELETE', route('admin.categories.destroy', ['category' => $category->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted('categories', [
            'name' => $category->name,
        ]);
    }
}

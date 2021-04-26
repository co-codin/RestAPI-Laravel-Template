<?php


namespace Tests\Feature\Modules\Category\Admin;

use Modules\Category\Models\Category;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_category()
//    {
//        //
//    }

    public function test_authenticated_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson(route('admin.categories.destroy', $category));

        $response->assertNoContent(204);

        $this->assertSoftDeleted($category);
    }
}

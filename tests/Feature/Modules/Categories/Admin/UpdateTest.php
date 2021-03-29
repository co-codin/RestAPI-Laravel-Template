<?php


namespace Tests\Feature\Modules\Categories\Admin;

use App\Enums\Status;
use Modules\Category\Models\Category;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_category()
    {
        //
    }

    public function test_authenticated_can_update_category()
    {
        $parentCategory = Category::factory()->create();

        $category = Category::factory()->create([
            'status' => Status::ONLY_URL,
        ]);

        $response = $this->json('PATCH', route('admin.categories.update', ['category' => $category->id]), [
            'name' => $newName = 'new name',
            'status' => Status::ACTIVE,
            'parent_id' => $parentCategory->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'name' => $newName,
            'status' => Status::ACTIVE,
        ]);
    }

    public function test_category_slug_should_be_unique()
    {
        $category = Category::factory()->create([
            'slug' => 'slug'
        ]);

        $anotherCategory = Category::factory()->create();

        $response = $this->json('PATCH', route('admin.categories.update', ['category' => $anotherCategory->id]), [
            'slug' => 'slug',
        ]);

        $response->assertStatus(422);
    }
}

<?php


namespace Tests\Feature\Modules\Category\Admin;

use Modules\Category\Models\Category;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_category()
    {
        $categoryData = Category::factory()->raw();

        $response = $this->json('POST', route('admin.categories.store'), $categoryData);

        $response->assertStatus(401);
    }
    public function test_authenticated_can_create_category()
    {
        $this->authenticateUser();

        $categoryData = Category::factory()->raw();

        $response = $this->json('POST', route('admin.categories.store'), $categoryData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'slug',
                'product_name',
                'full_description',
                'image',
                'status',
                'parent_id',
                'created_at',
                'updated_at',
            ]
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => $categoryData['name'],
        ]);
    }
}

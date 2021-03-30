<?php


namespace Tests\Feature\Modules\Categories\Admin;

use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_category()
    {
        $categoryData = Category::factory()->raw();

        $response = $this->json('POST', route('admin.categories.store'), $categoryData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'slug',
                'product_name',
                'full_description',
                'image',
                'status',
                'is_hidden_in_parents',
                'is_in_home',
                'parent_id',
                'short_properties',
                'created_at',
                'updated_at',
            ]
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => $categoryData['name'],
        ]);
    }
}

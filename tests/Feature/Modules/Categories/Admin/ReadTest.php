<?php

namespace Tests\Feature\Modules\Categories\Admin;

use Modules\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_category()
    {

    }

    public function test_authenticated_user_can_view_categories()
    {
        $this->withoutExceptionHandling();

        Category::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.categories.index'));

        $response->assertStatus(200);

        $this->assertEquals($count, count(($response['data'])));

        $response->assertJsonStructure([
            'data' => [
                [
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
                    'deleted_at',
                ]
            ]
        ]);
    }

    public function test_authenticated_user_can_view_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->json('GET', route('admin.categories.show', ['category' => $category->id]));

        $response->assertStatus(200);
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
                'deleted_at',
            ]
        ]);
    }
}

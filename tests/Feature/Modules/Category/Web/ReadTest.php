<?php

namespace Tests\Feature\Modules\Category\Web;

use Modules\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_categories()
    {
        Category::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('categories.index'));

        $response->assertOk();

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

    public function test_user_can_view_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->json('GET', route('categories.show', $category));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'slug',
                'product_name',
                'full_description',
                'image',
                'status',
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

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

    }
}

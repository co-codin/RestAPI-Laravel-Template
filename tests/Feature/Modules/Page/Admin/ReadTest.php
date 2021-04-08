<?php


namespace Tests\Feature\Modules\Page\Admin;

use Modules\Page\Models\Page;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_page()
    {

    }

    public function test_authenticated_user_can_view_pages()
    {
        $this->withoutExceptionHandling();

        Page::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.pages.index'));

        $response->assertStatus(200);
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "parent_id",
                    "name",
                    "slug",
                    "full_description",
                    "status",
                    "created_at",
                    "updated_at",
                    "deleted_at",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_authenticated_user_can_view_single_page()
    {
        $page = Page::factory()->create();

        $response = $this->json('GET', route('admin.pages.show', ['page' => $page->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                "id",
                "parent_id",
                "name",
                "slug",
                "full_description",
                "status",
                "created_at",
                "updated_at",
                "deleted_at",
            ]
        ]);
    }
}

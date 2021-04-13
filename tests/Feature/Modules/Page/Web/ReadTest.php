<?php


namespace Tests\Feature\Modules\Page\Web;

use Modules\Page\Models\Page;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_authenticated_user_can_view_pages()
    {
        Page::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('pages.index'));

        $response->assertOk();
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

    public function test_user_can_view_single_page()
    {
        $page = Page::factory()->create();

        $response = $this->json('GET', route('pages.show', $page));

        $response->assertOk();
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

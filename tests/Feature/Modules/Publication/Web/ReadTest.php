<?php


namespace Tests\Feature\Modules\Publication\Web;

use Modules\Publication\Models\Publication;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_publications()
    {
        Publication::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('publications.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "url",
                    "is_enabled",
                    "source",
                    "published_at",
                    "created_at",
                    "updated_at",
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

    public function test_user_can_view_single_publication()
    {
        $publication = Publication::factory()->create();

        $response = $this->json('GET', route('publications.show', ['publication' => $publication->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "url",
                "is_enabled",
                "source",
                "published_at",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

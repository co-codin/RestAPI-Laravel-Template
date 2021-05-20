<?php


namespace Tests\Feature\Modules\Seo\Web;

use Modules\Seo\Models\CanonicalEntity;
use Tests\TestCase;
use function route;

class CanonicalReadTest extends TestCase
{
    public function test_user_can_view_canonicals()
    {
        CanonicalEntity::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('canonicals.index'));

        $response->assertOk();

        $this->assertCount($count, ($response['data']));

        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "url",
                    "canonical",
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

    public function test_user_can_view_single_canonical()
    {
        $canonical = CanonicalEntity::factory()->create();

        $response = $this->json('GET', route('canonicals.show', $canonical));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "url",
                "canonical",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

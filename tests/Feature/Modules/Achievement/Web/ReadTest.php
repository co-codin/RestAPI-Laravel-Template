<?php


namespace Tests\Feature\Modules\Achievement\Web;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_achievements()
    {
        Achievement::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('achievements.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "image",
                    "is_enabled",
                    "position",
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

    public function test_user_can_view_single_achievement()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->json('GET', route('achievements.show', $achievement));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'image',
                'is_enabled',
                'position',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}

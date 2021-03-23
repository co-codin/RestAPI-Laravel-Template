<?php


namespace Tests\Feature\Modules\Achievements\Admin;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_achievement()
    {

    }

    public function test_authenticated_user_can_view_achievements()
    {
        Achievement::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.achievements.index'));

        $response->assertStatus(200);
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

    public function test_authenticated_user_can_view_single_achievement()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->json('GET', route('admin.achievements.show', ['achievement' => $achievement->id]));

        $response->assertStatus(200);
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

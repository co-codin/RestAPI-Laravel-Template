<?php


namespace Tests\Feature\Modules\Achievements\Web;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_active_achievements_can_be_viewed()
    {
        $achievement = Achievement::factory()->create([
            'is_enabled' => 1,
        ]);

        $response = $this->graphQL('
            {
                achievements {
                    data {
                        id
                        name
                    }
                    paginatorInfo {
                        currentPage
                        lastPage
                    }
                }
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'achievements' => [
                    'data' => [
                        [
                            'id' => $achievement->id,
                            'name' => $achievement->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                achievements(where: { column: ID, operator: EQ, value: 1 }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'achievements' => [
                    'data' => [
                        [
                            'id' => $achievement->id,
                            'name' => $achievement->name,
                        ]
                    ],
                ]
            ],
        ]);

    }

    public function test_achievements_can_be_filter()
    {

    }

}

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
                achievements(where: { column: ID, operator: EQ, value: ' . $achievement->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

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

    public function test_inactive_achievements_cannot_be_viewed()
    {
        $achievement = Achievement::factory()->create([
            'is_enabled' => 1,
        ]);

        $anotherAchievement = Achievement::factory()->create([
            'is_enabled' => 0,
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

        $this->assertNotContains($anotherAchievement->id, $response->json());


        $response = $this->graphQL('
            {
                achievements(where: { column: ID, operator: EQ, value: ' . $achievement->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

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

        $response = $this->graphQL('
            {
                achievements(where: { column: ID, operator: EQ, value: ' . $anotherAchievement->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');
        
        $response->assertJson([
            'data' => [
                'achievements' => [
                    'data' => [],
                ]
            ],
        ]);
    }

}

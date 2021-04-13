<?php


namespace Tests\Feature\Modules\Publication\Gql;

use Modules\Publication\Models\Publication;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_publications_can_be_viewed()
    {
        $publication = Publication::factory()->create([
            'is_enabled' => 0,
        ]);

        $response = $this->graphQL('
            {
                publications {
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
                'publications' => [
                    'data' => [
                        [
                            'id' => $publication->id,
                            'name' => $publication->name,
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
                publications(where: { column: ID, operator: EQ, value: ' . $publication->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'publications' => [
                    'data' => [
                        [
                            'id' => $publication->id,
                            'name' => $publication->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}

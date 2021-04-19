<?php


namespace Tests\Feature\Modules\Property\Gql;

use App\Enums\Status;
use Modules\Page\Models\Page;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_properties_can_be_viewed()
    {
        $property = Page::factory()->create();

        $response = $this->graphQL('
            {
                properties {
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
                'properties' => [
                    'data' => [
                        [
                            'id' => $property->id,
                            'name' => $property->name,
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
                pages(where: { column: ID, operator: EQ, value: ' . $page->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'pages' => [
                    'data' => [
                        [
                            'id' => $page->id,
                            'name' => $page->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}

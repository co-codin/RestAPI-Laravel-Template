<?php


namespace Tests\Feature\Modules\Page\Gql;

use App\Enums\Status;
use Modules\Page\Models\Page;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_pages_can_be_viewed()
    {
        $page = Page::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $response = $this->graphQL('
            {
                pages {
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
                'pages' => [
                    'data' => [
                        [
                            'id' => $page->id,
                            'name' => $page->name,
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

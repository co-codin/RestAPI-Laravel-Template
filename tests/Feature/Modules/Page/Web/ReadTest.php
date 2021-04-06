<?php


namespace Tests\Feature\Modules\Page\Web;

use App\Enums\Status;
use Modules\Page\Models\Page;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_active_pages_can_be_viewed()
    {
        $page = Page::factory()->create([
            'status' => Status::ACTIVE,
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

    public function test_inactive_pages_cannot_be_viewed()
    {
        $page = Page::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $anotherPage = Page::factory()->create([
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

        $this->assertNotContains($anotherPage->id, $response->json());

        $response = $this->graphQL('
            {
                pages(where: { column: ID, operator: EQ, value: ' . $page->id . ' }) {
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

        $response = $this->graphQL('
            {
                pages(where: { column: ID, operator: EQ, value: ' . $anotherPage->id . ' }) {
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
                    'data' => [],
                ]
            ],
        ]);
    }
}

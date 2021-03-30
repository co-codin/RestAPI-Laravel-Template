<?php


namespace Tests\Feature\Modules\Categories\Web;

use App\Enums\Status;
use Modules\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_active_categories_can_be_viewed()
    {
        $category = Category::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->graphQL('
            {
                categories {
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
                'categories' => [
                    'data' => [
                        [
                            'id' => $category->id,
                            'name' => $category->name,
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
                categories(where: { column: ID, operator: EQ, value: ' . $category->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'categories' => [
                    'data' => [
                        [
                            'id' => $category->id,
                            'name' => $category->name,
                        ]
                    ],
                ]
            ],
        ]);

    }

    public function test_inactive_categories_cannot_be_viewed()
    {
        $category = Category::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $secondCategory = Category::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $thirdCategory = Category::factory()->create([
            'status' => Status::ONLY_URL,
        ]);

        $response = $this->graphQL('
            {
                categories {
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
                'categories' => [
                    'data' => [
                        [
                            'id' => $secondCategory->id,
                            'name' => $secondCategory->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $this->assertNotContains($category->id, $response->json());
        $this->assertNotContains($thirdCategory->id, $response->json());


        $response = $this->graphQL('
            {
                categories(where: { column: ID, operator: EQ, value: ' . $secondCategory->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'categories' => [
                    'data' => [
                        [
                            'id' => $secondCategory->id,
                            'name' => $secondCategory->name,
                        ]
                    ],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                categories(where: { column: ID, operator: EQ, value: ' . $category->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'categories' => [
                    'data' => [],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                categories(where: { column: ID, operator: EQ, value: ' . $thirdCategory->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'categories' => [
                    'data' => [],
                ]
            ],
        ]);
    }
}

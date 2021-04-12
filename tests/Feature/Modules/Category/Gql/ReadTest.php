<?php


namespace Tests\Feature\Modules\Category\Gql;

use App\Enums\Status;
use Modules\Category\Models\Category;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_categories_can_be_viewed()
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
}

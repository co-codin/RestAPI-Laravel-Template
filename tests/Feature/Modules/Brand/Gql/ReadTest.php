<?php


namespace Tests\Feature\Modules\Brand\Gql;

use App\Enums\Status;
use Modules\Brand\Models\Brand;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_brands_can_be_viewed()
    {
        $brand = Brand::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->graphQL('
            {
                brands {
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
                'brands' => [
                    'data' => [
                        [
                            'id' => $brand->id,
                            'name' => $brand->name,
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
                brands(where: { column: ID, operator: EQ, value: ' . $brand->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'brands' => [
                    'data' => [
                        [
                            'id' => $brand->id,
                            'name' => $brand->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}

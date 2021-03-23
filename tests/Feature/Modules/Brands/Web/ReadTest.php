<?php


namespace Tests\Feature\Modules\Brands\Web;

use App\Enums\Status;
use Modules\Brand\Models\Brand;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_active_brands_can_be_viewed()
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

    public function test_inactive_brands_cannot_be_viewed()
    {
        $brand = Brand::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $secondBrand = Brand::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $thirdBrand = Brand::factory()->create([
            'status' => Status::ONLY_URL,
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
                            'id' => $secondBrand->id,
                            'name' => $secondBrand->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $this->assertNotContains($brand->id, $response->json());
        $this->assertNotContains($thirdBrand->id, $response->json());


        $response = $this->graphQL('
            {
                brands(where: { column: ID, operator: EQ, value: ' . $secondBrand->id . ' }) {
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
                            'id' => $secondBrand->id,
                            'name' => $secondBrand->name,
                        ]
                    ],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                brands(where: { column: ID, operator: EQ, value: ' . $brand->id . ' }) {
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
                    'data' => [],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                brands(where: { column: ID, operator: EQ, value: ' . $thirdBrand->id . ' }) {
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
                    'data' => [],
                ]
            ],
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Property\Gql;

use Modules\Property\Models\Property;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_properties_can_be_viewed()
    {
        $property = Property::factory()->create();

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
                properties(where: { column: ID, operator: EQ, value: ' . $property->id .'  }) {
                    data {
                        id
                        name
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
                ]
            ],
        ]);
    }

    public function test_properties_can_be_filtered_by_category_id()
    {
        $property = Property::factory()->create();


    }
}

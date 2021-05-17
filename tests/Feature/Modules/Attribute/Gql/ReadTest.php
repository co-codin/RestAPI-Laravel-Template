<?php


namespace Tests\Feature\Modules\Attribute\Gql;

use Modules\Attribute\Models\Attribute;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_attributes_can_be_viewed()
    {
        $attribute = Attribute::factory()->create();

        $response = $this->graphQL('
            {
                attributes {
                    data {
                        id
                        name
                        is_default
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
                'attributes' => [
                    'data' => [
                        [
                            'id' => $attribute->id,
                            'name' => $attribute->name,
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
                attributes(where: { column: ID, operator: EQ, value: ' . $attribute->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'attributes' => [
                    'data' => [
                        [
                            'id' => $attribute->id,
                            'name' => $attribute->name,
                        ]
                    ],
                ]
            ],
        ]);
    }

    public function test_single_attribute_can_be_viewed()
    {
        $attribute = Attribute::factory()->create();

        $response = $this->graphQL('
            {
                attribute (id: ' . $attribute->id . ') {
                    id
                    name
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'attribute' => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                ]
            ],
        ]);
    }
}

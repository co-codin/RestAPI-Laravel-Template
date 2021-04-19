<?php


namespace Tests\Feature\Modules\Property\Gql;

use Modules\Category\Models\Category;
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
        $anotherProperty = Property::factory()->create();
        $category = Category::factory()->create();

        $property->categories()->sync($category);

        $response = $this->graphQL('
            {
                properties(hasCategories: { column: ID, operator: EQ, value: ' . $category->id .'  }) {
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

        $response->assertJsonMissing([
            'data' => [
                'properties' => [
                    'data' => [
                        [
                            'id' => $anotherProperty->id,
                            'name' => $anotherProperty->name,
                        ]
                    ],
                ]
            ],
        ]);
    }
}

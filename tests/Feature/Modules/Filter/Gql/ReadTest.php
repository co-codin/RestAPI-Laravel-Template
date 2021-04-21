<?php


namespace Tests\Feature\Modules\Filter\Gql;

use Modules\Filter\Models\Filter;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_filters_can_be_viewed()
    {
        $filter = Filter::factory()->create();

        $response = $this->graphQL('
            {
                filters {
                    data {
                        id
                        name
                        slug
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
                'filters' => [
                    'data' => [
                        [
                            'id' => $filter->id,
                            'name' => $filter->name,
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
                filters(where: { column: ID, operator: EQ, value: ' . $filter->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'filters' => [
                    'data' => [
                        [
                            'id' => $filter->id,
                            'name' => $filter->name,
                        ]
                    ],
                ]
            ],
        ]);
    }

    public function test_single_filter_can_be_viewed()
    {
        $filter = Filter::factory()->create();

        $response = $this->graphQL('
            {
                filter (id: ' . $filter->id . ') {
                    id
                    name
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'filter' => [
                    'id' => $filter->id,
                    'name' => $filter->name,
                ]
            ],
        ]);
    }
}

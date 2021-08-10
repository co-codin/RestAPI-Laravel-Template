<?php

namespace Tests\Feature\Modules\Geo\Gql;

use Modules\Geo\Models\City;
use Tests\TestCase;

class CityReadTest extends TestCase
{
    public function test_cities_can_be_viewed()
    {
        $city = City::factory()->create();

        $response = $this->graphQL('
            {
                cities {
                    data {
                        id
                        region_name
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
                'cities' => [
                    'data' => [
                        [
                            'id' => $city->id,
                            'region_name' => $city->region_name,
                            'name' => $city->name,
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
                cities(where: { column: ID, operator: EQ, value: ' . $city->id .'  }) {
                    data {
                        id
                        region_name
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'cities' => [
                    'data' => [
                        [
                            'id' => $city->id,
                            'region_name' => $city->region_name,
                            'name' => $city->name
                        ]
                    ],
                ]
            ],
        ]);
    }
}

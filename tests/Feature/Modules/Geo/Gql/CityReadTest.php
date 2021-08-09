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
                        region_name_with_type
                        federal_district
                        iso
                        city_name
                        city_slug
                        status
                        is_default
                        coordinate
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
                            'city_name' => $city->region_name,
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
                        city_name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'questionCategories' => [
                    'data' => [
                        [
                            'id' => $city->id,
                            'region_name' => $city->region_name,
                            'city_name' => $city->city_name
                        ]
                    ],
                ]
            ],
        ]);
    }
}

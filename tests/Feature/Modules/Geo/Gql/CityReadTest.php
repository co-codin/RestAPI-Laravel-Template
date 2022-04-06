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
                        name
                        slug
                        status
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
                'cities' => [
                    'data' => [
                        [
                            'id' => $city->id,
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
                        slug
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
                            'slug' => $city->slug,
                            'name' => $city->name
                        ]
                    ],
                ]
            ],
        ]);
    }
}

<?php

namespace Tests\Feature\Modules\Geo\Gql;

use Modules\Geo\Models\OrderPoint;
use Tests\TestCase;

class OrderPointReadTest extends TestCase
{
    public function test_order_points_can_be_viewed()
    {
        $orderPoint = OrderPoint::factory()->create();

        $response = $this->graphQL('
            {
                order_points {
                    data {
                        id
                        city_id
                        name
                        address
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
                'order_points' => [
                    'data' => [
                        [
                            'id' => $orderPoint->id,
                            'city_id' => $orderPoint->city_id,
                            'name' => $orderPoint->name,
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
                order_points(where: { column: ID, operator: EQ, value: ' . $orderPoint->id .'  }) {
                    data {
                        id
                        city_id
                        name
                        address
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'order_points' => [
                    'data' => [
                        [
                            'id' => $orderPoint->id,
                            'city_id' => $orderPoint->city_id,
                            'name' => $orderPoint->name
                        ]
                    ],
                ]
            ],
        ]);
    }
}

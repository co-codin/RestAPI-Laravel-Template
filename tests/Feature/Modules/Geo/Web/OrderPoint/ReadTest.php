<?php

namespace Tests\Feature\Modules\Geo\Web\OrderPoint;

use Modules\Geo\Models\OrderPoint;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_order_points()
    {
        OrderPoint::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('order-points.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "city_id",
                    "name",
                    "address",
                    "coordinate",
                    "type",
                    "status",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_user_can_view_single_order_point()
    {
        $orderPoint = OrderPoint::factory()->create();

        $response = $this->json('GET', route('order-points.show', $orderPoint));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "city_id",
                "name",
                "address",
                "coordinate",
                "type",
                "status",
            ]
        ]);
    }
}

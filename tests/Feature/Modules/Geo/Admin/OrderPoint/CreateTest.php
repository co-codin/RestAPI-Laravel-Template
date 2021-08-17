<?php

namespace Tests\Feature\Modules\Geo\Admin\OrderPoint;

use Modules\Geo\Models\OrderPoint;
use Tests\TestCase;

class CreateTest extends TestCase
{
    //    public function test_unauthenticated_cannot_create_order_point()
//    {
//        //
//    }

    public function test_authenticated_user_can_create_order_point()
    {
        $orderPointData = OrderPoint::factory()->raw();

        $response = $this->json('POST', route('admin.order_points.store'), $orderPointData);

        $response->assertCreated();
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

        $this->assertDatabaseHas('order_points', [
            'name' => $orderPointData['name'],
            'address' => $orderPointData['address']
        ]);
    }
}

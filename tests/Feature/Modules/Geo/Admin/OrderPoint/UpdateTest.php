<?php

namespace Tests\Feature\Modules\Geo\Admin\OrderPoint;

use Modules\Geo\Models\OrderPoint;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    //    public function test_unauthenticated_cannot_update_order_point()
//    {
//        //
//    }

    public function test_authenticated_can_update_order_point()
    {
        $orderPoint = OrderPoint::factory()->create();

        $response = $this->json('PATCH', route('admin.order_points.update', $orderPoint), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('order_points', [
            'name' => $newName,
        ]);
    }
}

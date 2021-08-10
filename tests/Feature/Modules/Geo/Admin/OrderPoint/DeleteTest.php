<?php

namespace Tests\Feature\Modules\Geo\Admin\OrderPoint;

use Modules\Geo\Models\OrderPoint;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    //    public function test_unauthenticated_cannot_delete_order_point()
//    {
//        //
//    }

    public function test_authenticated_can_delete_order_point()
    {
        $orderPoint = OrderPoint::factory()->create();

        $response = $this->deleteJson(route('admin.order_points.destroy', $orderPoint));

        $response->assertNoContent();

        $this->assertDeleted($orderPoint);
    }
}

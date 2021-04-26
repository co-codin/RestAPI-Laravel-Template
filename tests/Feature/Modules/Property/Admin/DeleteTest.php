<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Property\Models\Property;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_property()
//    {
//        //
//    }

    public function test_authenticated_can_delete_property()
    {
        $property = Property::factory()->create();

        $response = $this->deleteJson(route('admin.properties.destroy', $property));

        $response->assertNoContent();

        $this->assertDeleted($property);
    }
}

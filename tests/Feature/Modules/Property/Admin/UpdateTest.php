<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Property\Models\Property;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_a_property()
    {
        $this->authenticateUser();

        $property = Property::factory()->create();

        $response = $this->json('PATCH', route('admin.properties.update', $property), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('properties', [
            'name' => $newName,
        ]);
    }
}

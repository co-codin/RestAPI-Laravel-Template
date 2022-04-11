<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Category\Models\Category;
use Modules\Property\Models\Property;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_property()
    {
        $this->authenticateUser();

        $propertyData = Property::factory()->raw();

        $response = $this->json('POST', route('admin.properties.store'), $propertyData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
            ]
        ]);

        $this->assertDatabaseHas('properties', [
            'name' => $propertyData['name'],
        ]);
    }
}

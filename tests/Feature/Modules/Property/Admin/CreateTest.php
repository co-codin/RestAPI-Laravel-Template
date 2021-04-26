<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Category\Models\Category;
use Modules\Property\Models\Property;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_property()
//    {
//        //
//    }

    public function test_authenticated_can_create_property()
    {
        $category = Category::factory()->create();

        $propertyData = Property::factory()->raw([
            'categories' => [
                [
                    'id' => $category->id,
                    'position' => $position = 5,
                ],
            ]
        ]);

        $response = $this->json('POST', route('admin.properties.store'), $propertyData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'type'
            ]
        ]);

        $this->assertDatabaseHas('properties', [
            'name' => $propertyData['name'],
        ]);

        $this->assertDatabaseHas('property_category', [
            'property_id' => $response['data']['id'],
            'category_id' => $category->id,
            'position' => $position,
        ]);
    }
}

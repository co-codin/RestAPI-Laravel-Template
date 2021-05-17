<?php


namespace Tests\Feature\Modules\Attribute\Admin;

use Modules\Achievement\Models\Achievement;
use Modules\Attribute\Models\Attribute;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_attribute()
//    {
//        //
//    }

    public function test_authenticated_can_create_attribute()
    {
        $attributeData = Attribute::factory()->raw();

        $response = $this->json('POST', route('admin.attributes.store'), $attributeData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'is_default',
            ]
        ]);

        $this->assertDatabaseHas('attributes', [
            'name' => $attributeData['name'],
            'is_default' => $attributeData['is_default']
        ]);
    }

    public function test_attribute_name_should_be_unique()
    {
         $attribute = Attribute::factory()->create();

        $response = $this->json('POST', route('admin.attributes.store'), [
            'name' => $attribute->name
        ]);

        $response->assertStatus(422);
    }
}

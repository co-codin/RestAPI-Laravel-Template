<?php


namespace Tests\Feature\Modules\Brands\Admin;

use Modules\Brand\Models\Brand;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_brand()
    {
        $brandData = Brand::factory()->raw();

        $response = $this->json('POST', route('admin.brands.store'), $brandData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
                'image',
                'short_description',
                'country',
                'website',
                'full_description',
                'status',
                'is_in_home',
                'position',
            ]
        ]);
        $this->assertDatabaseHas('brands', [
            'name' => $brandData['name'],
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Brand\Admin;

use Illuminate\Http\UploadedFile;
use Modules\Brand\Models\Brand;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_brand()
    {
        $brandData = Brand::factory()->raw();

        $response = $this->json('POST', route('admin.brands.store'), array_merge($brandData, [
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]));

        $response->assertStatus(401);
    }

    public function test_authenticated_can_create_brand()
    {
        $this->authenticateUser();

        $brandData = Brand::factory()->raw();

        $response = $this->json('POST', route('admin.brands.store'), $brandData);


        $response->assertCreated();
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

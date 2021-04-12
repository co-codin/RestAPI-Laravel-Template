<?php


namespace Tests\Feature\Modules\Brands\Admin;

use App\Enums\Status;
use Modules\Brand\Models\Brand;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_brand()
    {
        //
    }

    public function test_authenticated_can_update_brand()
    {
        $brand = Brand::factory()->create([
            'status' => Status::ONLY_URL,
        ]);

        $response = $this->json('PATCH', route('admin.brands.update', ['brand' => $brand->id]), [
            'name' => $newName = 'new name',
            'status' => Status::ACTIVE,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('brands', [
            'name' => $newName,
            'status' => Status::ACTIVE,
        ]);
    }

    public function test_brand_slug_should_be_unique()
    {
        $brand = Brand::factory()->create([
            'slug' => 'slug'
        ]);

        $anotherBrand = Brand::factory()->create();

        $response = $this->json('PATCH', route('admin.brands.update', ['brand' => $anotherBrand->id]), [
            'slug' => 'slug',
        ]);

        $response->assertStatus(422);
    }
}

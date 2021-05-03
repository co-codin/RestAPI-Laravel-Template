<?php


namespace Tests\Feature\Modules\Brand\Admin;

use App\Enums\Status;
use Illuminate\Http\UploadedFile;
use Modules\Brand\Models\Brand;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_brand()
//    {
//        //
//    }

    public function test_authenticated_can_update_brand()
    {
        $brand = Brand::factory()->create([
            'status' => Status::ONLY_URL,
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $response = $this->json('PATCH', route('admin.brands.update', $brand), [
            'name' => $newName = 'new name',
            'status' => Status::ACTIVE,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('brands', [
            'name' => $newName,
            'status' => Status::ACTIVE,
        ]);
    }

    public function test_brand_slug_should_be_unique()
    {
        Brand::factory()->create([
            'slug' => 'slug'
        ]);

        $anotherBrand = Brand::factory()->create();

        $response = $this->json('PATCH', route('admin.brands.update', $anotherBrand), [
            'slug' => 'slug',
        ]);

        $response->assertStatus(422);
    }
}

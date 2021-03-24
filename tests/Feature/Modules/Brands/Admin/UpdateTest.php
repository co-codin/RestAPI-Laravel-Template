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
}

<?php


namespace Tests\Feature\Modules\Brands\Admin;

use Modules\Brand\Models\Brand;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_brand()
    {
        //
    }

    public function test_authenticated_can_delete_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->json('DELETE', route('admin.brands.destroy', ['brand' => $brand->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted('brands', [
            'name' => $brand->name,
        ]);
    }
}

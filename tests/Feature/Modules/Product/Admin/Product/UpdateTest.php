<?php


namespace Tests\Feature\Modules\Product\Admin\Product;

use App\Enums\Status;
use Modules\Product\Models\Product;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_page()
//    {
//        //
//    }

    public function test_authenticated_can_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->json('PATCH', route('admin.products.update', $product), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('products', [
            'name' => $newName,
        ]);
    }
}

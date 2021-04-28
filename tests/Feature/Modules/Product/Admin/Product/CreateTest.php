<?php


namespace Tests\Feature\Modules\Product\Admin\Product;

use Modules\Category\Models\Category;
use Modules\Product\Models\Product;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_product()
    {
        //
    }

    public function test_authenticated_can_create_product()
    {
        $category = Category::factory()->create();

        $productData = Product::factory()->raw();

        $response = $this->json('POST', route('admin.products.store'), array_merge($productData, [
            'categories' => [
                ['id' => $category->id, 'is_main' => true]
            ]
        ]));

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
            ]
        ]);

        $this->assertDatabaseHas('products', [
            'name' => $productData['name'],
            'slug' => $productData['slug']
        ]);
    }
}

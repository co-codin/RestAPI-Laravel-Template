<?php


namespace Tests\Feature\Modules\Product\Admin\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
                ['id' => $category->id, 'is_main' => $isMain = true]
            ],
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

        $this->assertDatabaseHas('product_category', [
            'product_id' => $response['data']['id'],
            'category_id' => $category->id,
            'is_main' => $isMain,
        ]);
    }
}
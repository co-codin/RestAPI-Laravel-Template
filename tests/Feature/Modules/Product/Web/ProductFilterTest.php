<?php

namespace Tests\Feature\Modules\Product\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;
use Tests\CreatesApplication;

class ProductFilterTest extends TestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * @test
     */
    public function it_filters_products_by_category()
    {
        /* @var Category $category */
        $category = Category::factory()->create();
        /* @var Product $product */
        $product = Product::factory()->create();
        $product->categories()->attach($category);

        $this->getJson(route('products.filter'), [
            'filter[category_id]' => $category->id,
        ])->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                ]
            ],
        ]);
    }
}

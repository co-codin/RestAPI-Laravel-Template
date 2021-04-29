<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use Modules\Product\Enums\ProductVariantStock;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;
use Tests\TestCase;
use function React\Promise\map;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_configurator()
//    {
//        //
//    }

    public function test_authenticated_can_create_configurator()
    {
        $product = Product::factory()->create();

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variants' => [
                    $productVariant = ProductVariant::factory()->raw([
                        'product_id' => null
                    ]),
                    $anotherProductVariant = ProductVariant::factory()->raw([
                        'product_id' => null
                    ]),
                ],
            ],
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variants', array_merge($productVariant, [
            'product_id' => $product->id
        ]));

        $this->assertDatabaseHas('product_variants', array_merge($anotherProductVariant, [
            'product_id' => $product->id
        ]));
    }

    public function test_authenticated_can_update_configurator()
    {
        $product = Product::factory()->create();

        $productVariant = ProductVariant::factory()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variants' => [
                    [
                        'id' => $productVariant->id,
                        'name' => $newName = 'new_name',
                        'is_price_visible' => true,
                        'is_enabled' => true,
                        'availability' => ProductVariantStock::ComingSoon,
                    ]
                ],
            ],
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => $newName,
        ]);
    }

    public function test_authenticated_can_create_and_update_configurator()
    {
        $product = Product::factory()->create();

        $productVariant = ProductVariant::factory()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variants' => [
                    [
                        'id' => $productVariant->id,
                        'name' => $newName = 'new_name',
                        'is_price_visible' => true,
                        'is_enabled' => true,
                        'availability' => ProductVariantStock::ComingSoon,
                    ],
                    $productVariantData = ProductVariant::factory()->raw([
                        'product_id' => null
                    ]),
                ],
            ],
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variants', array_merge($productVariantData, [
            'product_id' => $product->id
        ]));

        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => $newName,
        ]);
    }
}

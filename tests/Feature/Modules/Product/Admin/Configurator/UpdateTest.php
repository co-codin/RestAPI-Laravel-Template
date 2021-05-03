<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use Illuminate\Http\UploadedFile;
use Modules\Product\Enums\ProductVariationStock;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
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
        $product = Product::factory()->create([
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variants' => [
                    $productVariant = ProductVariation::factory()->raw([
                        'product_id' => null
                    ]),
                    $anotherProductVariant = ProductVariation::factory()->raw([
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

        $productVariant = ProductVariation::factory()->create([
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
                        'availability' => ProductVariationStock::ComingSoon,
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

        $productVariant = ProductVariation::factory()->create([
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
                        'availability' => ProductVariationStock::ComingSoon,
                    ],
                    $productVariantData = ProductVariation::factory()->raw([
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

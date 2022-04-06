<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use Modules\Product\Enums\Availability;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Tests\TestCase;
use function React\Promise\map;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_create_configurator()
    {
        $this->authenticateUser();

        $product = Product::factory()->create();

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variations' => [
                    $productVariation = ProductVariation::factory()->raw([
                        'product_id' => null
                    ]),
                    $anotherProductVariation = ProductVariation::factory()->raw([
                        'product_id' => null
                    ]),
                ],
            ],
        );

        dd(
            $response->json()
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variations', array_merge($productVariation, [
            'product_id' => $product->id
        ]));

        $this->assertDatabaseHas('product_variations', array_merge($anotherProductVariation, [
            'product_id' => $product->id
        ]));
    }

    public function test_authenticated_can_update_configurator()
    {
        $product = Product::factory()->create();

        $productVariation = ProductVariation::factory()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variations' => [
                    [
                        'id' => $productVariation->id,
                        'name' => $newName = 'new_name',
                        'is_price_visible' => true,
                        'is_enabled' => true,
                        'availability' => Availability::COMING_SOON,
                    ]
                ],
            ],
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variations', [
            'product_id' => $product->id,
            'name' => $newName,
        ]);
    }

    public function test_authenticated_can_create_and_update_configurator()
    {
        $product = Product::factory()->create();

        $productVariation = ProductVariation::factory()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variations' => [
                    [
                        'id' => $productVariation->id,
                        'name' => $newName = 'new_name',
                        'is_price_visible' => true,
                        'is_enabled' => true,
                        'availability' => Availability::COMING_SOON,
                    ],
                    $productVariationData = ProductVariation::factory()->raw([
                        'product_id' => null
                    ]),
                ],
            ],
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variations', array_merge($productVariationData, [
            'product_id' => $product->id
        ]));

        $this->assertDatabaseHas('product_variations', [
            'product_id' => $product->id,
            'name' => $newName,
        ]);
    }
}

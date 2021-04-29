<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use Modules\Currency\Models\Currency;
use Modules\Product\Enums\ProductVariantStock;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_configurator()
//    {
//        //
//    }

    public function test_authenticated_can_update_configurator()
    {
        $product = Product::factory()->create();

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variants' => $this->getData(),
            ],
        );

        $response->assertNoContent();

        $this->assertDatabaseHas('product_variants', [
            'name' =>  'name_two',
        ]);

        $this->assertDatabaseMissing('product_variants', [
            'name' => 'name_one'
        ]);
    }

    protected function getData(): array
    {
        $productVariant = ProductVariant::factory()->create();

        $anotherProductVariant = ProductVariant::factory()->create();

        return [
            [
                'id' => $productVariant->id,
                'name' => 'name_one',
                'price' => 100,
                'previous_price' => 50,
                'currency_id' => Currency::factory()->create()->id,
                'is_price_visible' => true,
                'is_enabled' => true,
                'availability' => ProductVariantStock::InStock,
            ],
            [
                'name' =>  'name_two',
                'price' => 200,
                'previous_price' => 100,
                'currency_id' => Currency::factory()->create()->id,
                'is_price_visible' => false,
                'is_enabled' => true,
                'availability' => ProductVariantStock::UnderTheOrder,
            ],
            [
                'id' => $anotherProductVariant->id,
                'name' => 'name_three',
                'price' => 300,
                'previous_price' => 150,
                'currency_id' => Currency::factory()->create()->id,
                'is_price_visible' => true,
                'is_enabled' => true,
                'availability' => ProductVariantStock::ComingSoon,
            ],
        ];
    }
}

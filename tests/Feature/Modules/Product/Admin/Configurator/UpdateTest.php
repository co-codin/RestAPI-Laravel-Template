<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use App\Models\FieldValue;
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
                    ProductVariation::factory()->raw([
                        'product_id' => null,
                        'condition_id' => FieldValue::factory(),
                        'is_enabled' => true
                    ]),
                    ProductVariation::factory()->raw([
                        'product_id' => null,
                        'condition_id' => FieldValue::factory()
                    ]),
                ],
            ],
        );

        $response->assertOk();
    }
}

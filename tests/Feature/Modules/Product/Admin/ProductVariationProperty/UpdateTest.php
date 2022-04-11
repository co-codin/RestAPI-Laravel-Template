<?php

namespace Tests\Feature\Modules\Product\Admin\ProductVariationProperty;

use Modules\Product\Models\ProductVariation;
use Modules\Property\Models\Property;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_product_variation_property()
    {
        $this->authenticateUser();

        $productVariation = ProductVariation::factory()->create();

        $property = Property::factory()->create();

        $response = $this->json('PUT', route('admin.product.variation.property.update'), [
            'property_id' => $property->id,
            'product_variation_id' => $productVariation->id,
        ]);

        $response->assertNoContent();
    }
}

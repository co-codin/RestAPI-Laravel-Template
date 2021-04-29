<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use App\Enums\Status;
use Modules\Product\Models\Product;
use Modules\Property\Models\Property;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_configurator()
//    {
//        //
//    }

    public function test_authenticated_can_update_configurator()
    {
//        $product = Product::factory()->create();
//
//        $property = Property::factory()->create();
//
//        $response = $this->json('PUT', route('admin.product.property.update', $product), [
//            'properties' => [
//                [
//                    'id' => $property->id,
//                    'pretty_key' => $prettyKey = 'test_key',
//                    'pretty_value' => $prettyValue = 'test_value',
//                ],
//            ]
//        ]);
//
//        $response->assertNoContent();
//
//        $this->assertDatabaseHas('property_value', [
//            'property_id' => $property->id,
//            'product_id' => $product->id,
//            'pretty_key' => $prettyKey,
//            'pretty_value' => $prettyValue,
//        ]);
    }
}

<?php

namespace Tests\Feature\Modules\Geo\Gql;

use Modules\Geo\Models\SoldProduct;
use Tests\TestCase;

class SoldProductReadTest extends TestCase
{
    public function test_sold_products_can_be_viewed()
    {
        $soldProduct = SoldProduct::factory()->create([
            'is_enabled' => true,
        ]);

        $response = $this->graphQL('
            {
                sold_products {
                    id
                    name
                    product_id
                    city_id
                    type
                    is_enabled
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'sold_products' => [
                    [
                        'id' => $soldProduct->id,
                        'name' => $soldProduct->name,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                sold_products(where: { column: ID, operator: EQ, value: ' . $soldProduct->id .'  }) {
                    id
                    name
                    product_id
                    city_id
                    type
                    is_enabled
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'sold_products' => [
                    [
                        'id' => $soldProduct->id,
                        'name' => $soldProduct->name,
                    ]
                ]
            ],
        ]);
    }
}

<?php

namespace Tests\Feature\Modules\Geo\Web\SoldProduct;

use Modules\Geo\Models\SoldProduct;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_sold_products()
    {
        SoldProduct::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('sold-products.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "title",
                    "product_id",
                    "city_id",
                    "category_id",
                    "type",
                    "status",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_user_can_view_single_sold_product()
    {
        $soldProduct = SoldProduct::factory()->create();

        $response = $this->json('GET', route('sold-products.show', $soldProduct));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "title",
                "product_id",
                "city_id",
                "category_id",
                "type",
                "status",
            ]
        ]);
    }
}

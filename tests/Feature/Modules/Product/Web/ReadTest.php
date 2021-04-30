<?php


namespace Tests\Feature\Modules\Product\Web;


use Modules\Product\Models\Product;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_products()
    {
        Product::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('products.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "slug",
                    "brand_id",
                    "status",
                    "image",
                    "is_in_home",
                    "warranty",
                    "short_description",
                    "full_description",
                    "created_at",
                    "updated_at",
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

    public function test_user_can_view_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->json('GET', route('products.show', $product));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "slug",
                "brand_id",
                "status",
                "image",
                "is_in_home",
                "warranty",
                "short_description",
                "full_description",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

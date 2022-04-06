<?php


namespace Tests\Feature\Modules\Brand\Web;

use Modules\Brand\Models\Brand;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_brands()
    {
        Brand::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('brands.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'slug',
                    'image',
                    'short_description',
                    'website',
                    'country_id',
                    'full_description',
                    'status',
                    'is_in_home',
                    'position',
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

    public function test_user_can_view_single_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->json('GET', route('brands.show', $brand));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
                'image',
                'short_description',
                'country_id',
                'website',
                'full_description',
                'status',
                'is_in_home',
                'position',
            ]
        ]);
    }
}

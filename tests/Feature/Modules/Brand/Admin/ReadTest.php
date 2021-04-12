<?php


namespace Tests\Feature\Modules\Brands\Admin;

use Modules\Brand\Models\Brand;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_brand()
    {

    }

    public function test_authenticated_user_can_view_brands()
    {
        Brand::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.brands.index'));

        $response->assertStatus(200);
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'slug',
                    'image',
                    'short_description',
                    'country',
                    'website',
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

    public function test_authenticated_user_can_view_single_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->json('GET', route('admin.brands.show', ['brand' => $brand->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
                'image',
                'short_description',
                'country',
                'website',
                'full_description',
                'status',
                'is_in_home',
                'position',
            ]
        ]);
    }
}

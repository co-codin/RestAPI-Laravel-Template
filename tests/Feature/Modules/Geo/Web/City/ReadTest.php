<?php

namespace Tests\Feature\Modules\Geo\Web\City;

use Modules\Geo\Models\City;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_cities()
    {
        City::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('cities.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "region_name",
                    "region_name_with_type",
                    "city_name",
                    "city_slug",
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

    public function test_user_can_view_single_city()
    {
        $city = City::factory()->create();

        $response = $this->json('GET', route('cities.show', $city));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "region_name",
                "region_name_with_type",
                "city_name",
                "city_slug",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

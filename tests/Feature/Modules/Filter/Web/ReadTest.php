<?php


namespace Tests\Feature\Modules\Filter\Web;

use Modules\Filter\Models\Filter;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_filters()
    {
        Filter::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('filters.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "slug",
                    "property_id",
                    "category_id",
                    "is_enabled",
                    "position",
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

    public function test_user_can_view_single_filter()
    {
        $filter = Filter::factory()->create();

        $response = $this->json('GET', route('filters.show', $filter));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "slug",
                "property_id",
                "category_id",
                "is_enabled",
                "position",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

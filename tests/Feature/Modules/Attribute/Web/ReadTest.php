<?php


namespace Tests\Feature\Modules\Attribute\Web;

use Modules\Attribute\Models\Attribute;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_attributes()
    {
        Attribute::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('attributes.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "is_default",
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

    public function test_user_can_view_single_attribute()
    {
        $attribute = Attribute::factory()->create();

        $response = $this->json('GET', route('attributes.show', $attribute));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "is_default",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

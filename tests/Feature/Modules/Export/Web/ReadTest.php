<?php


namespace Tests\Feature\Modules\Export\Web;


use Modules\Export\Models\Export;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_exports()
    {
        Export::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('exports.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "type",
                    "filename",
                    "frequency",
                    "parameters",
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

    public function test_user_can_view_single_export()
    {
        $export = Export::factory()->create();

        $response = $this->json('GET', route('exports.show', $export));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "type",
                "filename",
                "frequency",
                "parameters",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

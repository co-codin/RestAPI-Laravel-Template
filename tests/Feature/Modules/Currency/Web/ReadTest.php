<?php


namespace Tests\Feature\Modules\Currency\Web;


use Modules\Currency\Models\Currency;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_currencies()
    {
        Currency::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('currencies.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "iso_code",
                    "is_main",
                    "created_at",
                    "updated_at",
                    "deleted_at",
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

    public function test_user_can_view_single_currency()
    {
        $currency = Currency::factory()->create();

        $response = $this->json('GET', route('currencies.show', $currency));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "iso_code",
                "is_main",
                "created_at",
                "updated_at",
                "deleted_at",
            ]
        ]);
    }
}

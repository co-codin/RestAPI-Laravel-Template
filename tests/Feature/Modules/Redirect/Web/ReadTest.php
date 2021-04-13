<?php


namespace Tests\Feature\Modules\Redirect\Web;


use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_redirects()
    {
        Redirect::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('redirects.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "old_url",
                    "new_url",
                    "code",
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

    public function test_user_can_view_single_redirect()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->json('GET', route('redirects.show', $redirect));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "old_url",
                "new_url",
                "code",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_redirect()
    {

    }

    public function test_authenticated_user_can_view_redirects()
    {
        $this->withoutExceptionHandling();

        Redirect::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.redirects.index'));

        $response->assertStatus(200);
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

    public function test_authenticated_user_can_view_single_redirect()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->json('GET', route('admin.redirects.show', ['redirect' => $redirect->id]));

        $response->assertStatus(200);
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

<?php


namespace Tests\Feature\Modules\Role\Web\Role;


use Modules\Role\Models\Role;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_roles()
    {
        Role::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('roles.index'));

        dd(
            $response->json()
        );

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "source",
                    "destination",
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
                "source",
                "destination",
                "code",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

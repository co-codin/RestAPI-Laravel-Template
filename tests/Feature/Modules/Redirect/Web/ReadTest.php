<?php


namespace Tests\Feature\Modules\Redirect\Web;


use Modules\Redirect\Enums\RedirectPermission;
use Modules\Redirect\Models\Redirect;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class ReadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => RedirectPermission::VIEW_REDIRECTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

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

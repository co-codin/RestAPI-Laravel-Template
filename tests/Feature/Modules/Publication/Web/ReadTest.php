<?php


namespace Tests\Feature\Modules\Publication\Web;

use Modules\Publication\Enums\PublicationPermission;
use Modules\Publication\Models\Publication;
use Modules\Redirect\Enums\RedirectPermission;
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
            'name' => PublicationPermission::VIEW_PUBLICATIONS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_user_can_view_publications()
    {
        Publication::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('publications.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "url",
                    "logo",
                    "is_enabled",
                    "source",
                    "published_at",
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

    public function test_user_can_view_single_publication()
    {
        $publication = Publication::factory()->create();

        $response = $this->json('GET', route('publications.show', ['publication' => $publication->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "url",
                "logo",
                "is_enabled",
                "source",
                "published_at",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

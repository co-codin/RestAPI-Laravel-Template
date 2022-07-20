<?php


namespace Tests\Feature\Modules\Seo\Web;

use Modules\Role\Models\Permission;
use Modules\Seo\Enums\CanonicalPermission;
use Modules\Seo\Models\Canonical;
use Modules\User\Models\User;
use Tests\TestCase;
use function route;

class CanonicalReadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => CanonicalPermission::VIEW_CANONICALS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_user_can_view_canonicals()
    {
        Canonical::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('canonicals.index'));

        $response->assertOk();

        $this->assertCount($count, ($response['data']));

        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "url",
                    "canonical",
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

    public function test_user_can_view_a_single_canonical()
    {
        $canonical = Canonical::factory()->create();

        $response = $this->json('GET', route('canonicals.show', $canonical));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "url",
                "canonical",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

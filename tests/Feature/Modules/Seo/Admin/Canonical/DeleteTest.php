<?php


namespace Tests\Feature\Modules\Seo\Admin\Canonical;

use Modules\Role\Models\Permission;
use Modules\Seo\Enums\CanonicalPermission;
use Modules\Seo\Models\Canonical;
use Modules\User\Models\User;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => CanonicalPermission::DELETE_CANONICALS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_canonical()
    {
        $canonical = Canonical::factory()->create();

        $response = $this->json('DELETE', route('admin.canonicals.destroy', $canonical));

        $response->assertNoContent();

        $this->assertModelMissing($canonical);
    }
}

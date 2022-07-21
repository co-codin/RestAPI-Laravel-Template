<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Enums\RedirectPermission;
use Modules\Redirect\Models\Redirect;
use Modules\Role\Models\Permission;
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
            'name' => RedirectPermission::DELETE_REDIRECTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_redirect()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->json('DELETE', route('admin.redirects.destroy', $redirect));

        $response->assertNoContent();

        $this->assertModelMissing($redirect);
    }
}

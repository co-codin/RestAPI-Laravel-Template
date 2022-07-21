<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Enums\RedirectPermission;
use Modules\Redirect\Models\Redirect;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => RedirectPermission::EDIT_REDIRECTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_update_redirect()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->json('PATCH', route('admin.redirects.update', $redirect), [
            'source' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('redirects', [
            'source' => $newName,
        ]);
    }
}

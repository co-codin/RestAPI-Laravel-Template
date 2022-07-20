<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Enums\RedirectPermission;
use Modules\Redirect\Models\Redirect;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => RedirectPermission::CREATE_REDIRECTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_redirect()
    {
        $redirectData = Redirect::factory()->raw();

        $response = $this->json('POST', route('admin.redirects.store'), $redirectData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'destination',
                'source',
                'code',
            ]
        ]);
        $this->assertDatabaseHas('redirects', [
            'destination' => $redirectData['destination'],
            'source' => $redirectData['source'],
        ]);
    }
}

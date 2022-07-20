<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Modules\Publication\Enums\PublicationPermission;
use Modules\Publication\Models\Publication;
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
            'name' => PublicationPermission::EDIT_PUBLICATIONS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_update_publication()
    {
        $publication = Publication::factory()->create([
            'is_enabled' => true,
        ]);

        $response = $this->json('PATCH', route('admin.publications.update', $publication), [
            'name' => $newName = 'new name',
            'is_enabled' => false,
            'image' => null,
            'is_logo_changed' => true,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('publications', [
            'name' => $newName,
            'is_enabled' => false,
        ]);
        $this->assertEmpty(Publication::query()->first()->image);
    }
}

<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Modules\Publication\Enums\PublicationPermission;
use Modules\Publication\Models\Publication;
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
            'name' => PublicationPermission::DELETE_PUBLICATIONS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_publication()
    {
        $publication = Publication::factory()->create();

        $response = $this->deleteJson(route('admin.publications.destroy', $publication));

        $response->assertNoContent();

        $this->assertModelMissing($publication);
    }
}

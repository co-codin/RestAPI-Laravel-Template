<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Illuminate\Support\Facades\Storage;
use Modules\Publication\Enums\PublicationPermission;
use Modules\Publication\Models\Publication;
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
            'name' => PublicationPermission::CREATE_PUBLICATIONS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_publication()
    {
        $publicationData = Publication::factory()->raw();

        $response = $this->json('POST', route('admin.publications.store'), $publicationData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'url',
                'is_enabled',
                'logo'
            ]
        ]);
        $this->assertDatabaseHas('publications', [
            'name' => $publicationData['name'],
            'url' => $publicationData['url'],
            'is_enabled' => $publicationData['is_enabled'],
        ]);
        $this->assertTrue(Storage::disk('public')->has($response['data']['logo']));
    }
}

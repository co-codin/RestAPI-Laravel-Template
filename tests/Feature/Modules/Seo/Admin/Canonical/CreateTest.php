<?php


namespace Tests\Feature\Modules\Seo\Admin\Canonical;

use Modules\Role\Models\Permission;
use Modules\Seo\Enums\CanonicalPermission;
use Modules\Seo\Models\Canonical;
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
            'name' => CanonicalPermission::CREATE_CANONICALS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_canonical()
    {
        $canonicalData = Canonical::factory()->raw();

        $response = $this->json('POST', route('admin.canonicals.store'), $canonicalData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'url',
                'canonical',
            ]
        ]);

        $this->assertDatabaseHas('canonicals', [
            'url' => $canonicalData['url'],
            'canonical' => $canonicalData['canonical'],
        ]);
    }
}

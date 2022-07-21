<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Property\Enums\PropertyPermission;
use Modules\Property\Models\Property;
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
            'name' => PropertyPermission::DELETE_PROPERTIES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_property()
    {
        $property = Property::factory()->create();

        $response = $this->deleteJson(route('admin.properties.destroy', $property));

        $response->assertNoContent();

        $this->assertModelMissing($property);
    }
}

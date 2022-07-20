<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Property\Enums\PropertyPermission;
use Modules\Property\Models\Property;
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
            'name' => PropertyPermission::EDIT_PROPERTIES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_update_a_property()
    {
        $property = Property::factory()->create();

        $response = $this->json('PATCH', route('admin.properties.update', $property), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('properties', [
            'name' => $newName,
        ]);
    }
}

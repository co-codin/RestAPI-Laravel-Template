<?php


namespace Tests\Feature\Modules\Attribute\Admin;

use Modules\Attribute\Enums\AttributePermission;
use Modules\Attribute\Models\Attribute;
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
            'name' => AttributePermission::EDIT_ATTRIBUTES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_update_attribute()
    {
        $achievement = Attribute::factory()->create([
            'is_default' => true,
        ]);

        $response = $this->json('PATCH', route('admin.attributes.update', $achievement), [
            'name' => $newName = 'new name',
            'is_default' => false
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('attributes', [
            'name' => $newName,
            'is_default' => false
        ]);
    }
}

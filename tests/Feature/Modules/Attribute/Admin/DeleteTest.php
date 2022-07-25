<?php


namespace Tests\Feature\Modules\Attribute\Admin;

use Modules\Attribute\Enums\AttributePermission;
use Modules\Attribute\Models\Attribute;
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
            'name' => AttributePermission::DELETE_ATTRIBUTES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_attribute()
    {
        $attribute = Attribute::factory()->create();

        $response = $this->deleteJson(route('admin.attributes.destroy', $attribute));

        $response->assertNoContent();

        $this->assertSoftDeleted($attribute);
    }
}

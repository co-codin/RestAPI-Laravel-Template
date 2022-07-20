<?php


namespace Tests\Feature\Modules\Attribute\Admin;

use Modules\Attribute\Enums\AttributePermission;
use Modules\Attribute\Models\Attribute;
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
            'name' => AttributePermission::CREATE_ATTRIBUTES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_attribute()
    {
        $attributeData = Attribute::factory()->raw();

        $response = $this->json('POST', route('admin.attributes.store'), $attributeData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'is_default',
            ]
        ]);

        $this->assertDatabaseHas('attributes', [
            'name' => $attributeData['name'],
            'is_default' => $attributeData['is_default']
        ]);
    }

    public function test_attribute_name_should_be_unique()
    {
         $attribute = Attribute::factory()->create();

        $response = $this->json('POST', route('admin.attributes.store'), [
            'name' => $attribute->name
        ]);

        $response->assertStatus(422);
    }
}

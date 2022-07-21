<?php


namespace Tests\Feature\Modules\Property\Admin;


use Modules\Category\Models\Category;
use Modules\Property\Enums\PropertyPermission;
use Modules\Property\Models\Property;
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
            'name' => PropertyPermission::CREATE_PROPERTIES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_property()
    {
        $propertyData = Property::factory()->raw();

        $response = $this->json('POST', route('admin.properties.store'), $propertyData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
            ]
        ]);

        $this->assertDatabaseHas('properties', [
            'name' => $propertyData['name'],
        ]);
    }
}

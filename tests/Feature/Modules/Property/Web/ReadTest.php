<?php


namespace Tests\Feature\Modules\Property\Web;

use Modules\Property\Enums\PropertyPermission;
use Modules\Property\Models\Property;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class ReadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => PropertyPermission::VIEW_PROPERTIES
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_user_can_view_properties()
    {
        Property::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('properties.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "options",
                    "description",
                    "is_hidden_from_product",
                    "is_hidden_from_comparison",
                    "created_at",
                    "updated_at",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
        ]);
    }

    public function test_user_can_view_single_property()
    {
        $property = Property::factory()->create();

        $response = $this->json('GET', route('properties.show', $property));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "options",
                "description",
                "is_hidden_from_product",
                "is_hidden_from_comparison",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

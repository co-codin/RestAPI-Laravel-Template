<?php


namespace Tests\Feature\Modules\Brand\Admin;

use Illuminate\Http\UploadedFile;
use Modules\Brand\Enums\BrandPermission;
use Modules\Brand\Models\Brand;
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
            'name' => BrandPermission::CREATE_BRANDS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_brand()
    {
        $brandData = Brand::factory()->raw();

        $response = $this->json('POST', route('admin.brands.store'), $brandData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
                'image',
                'short_description',
                'country',
                'website',
                'full_description',
                'status',
                'is_in_home',
                'position',
            ]
        ]);
        $this->assertDatabaseHas('brands', [
            'name' => $brandData['name'],
        ]);
    }
}

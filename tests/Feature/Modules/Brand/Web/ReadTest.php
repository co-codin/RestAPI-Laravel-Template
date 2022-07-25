<?php


namespace Tests\Feature\Modules\Brand\Web;

use Modules\Brand\Enums\BrandPermission;
use Modules\Brand\Models\Brand;
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
            'name' => BrandPermission::VIEW_BRANDS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_user_can_view_brands()
    {
        Brand::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('brands.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'slug',
                    'image',
                    'short_description',
                    'website',
                    'country_id',
                    'full_description',
                    'status',
                    'is_in_home',
                    'position',
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_user_can_view_single_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->json('GET', route('brands.show', $brand));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
                'image',
                'short_description',
                'country_id',
                'website',
                'full_description',
                'status',
                'is_in_home',
                'position',
            ]
        ]);
    }
}

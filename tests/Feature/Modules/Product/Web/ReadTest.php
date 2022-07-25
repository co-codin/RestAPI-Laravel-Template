<?php


namespace Tests\Feature\Modules\Product\Web;


use Modules\Product\Enums\ProductPermission;
use Modules\Product\Models\Product;
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
            'name' => ProductPermission::VIEW_PRODUCTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_user_can_view_products()
    {
        Product::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('products.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "slug",
                    "brand_id",
                    "status",
                    "image",
                    "is_in_home",
                    "warranty",
                    "short_description",
                    "full_description",
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

    public function test_user_can_view_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->json('GET', route('products.show', $product));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "slug",
                "brand_id",
                "status",
                "image",
                "is_in_home",
                "warranty",
                "short_description",
                "full_description",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

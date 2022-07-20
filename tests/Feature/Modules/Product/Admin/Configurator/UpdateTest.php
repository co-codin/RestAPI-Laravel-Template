<?php


namespace Tests\Feature\Modules\Product\Admin\Configurator;

use App\Models\FieldValue;
use Modules\Product\Enums\ProductPermission;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;
use function React\Promise\map;

class UpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => ProductPermission::EDIT_PRODUCTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_configurator()
    {
        $product = Product::factory()->create();

        $response = $this->json(
            'PUT',
            route('admin.product.configurator.update', $product),
            [
                'variations' => [
                    ProductVariation::factory()->raw([
                        'product_id' => null,
                        'condition_id' => FieldValue::factory(),
                        'is_enabled' => true
                    ]),
                    ProductVariation::factory()->raw([
                        'product_id' => null,
                        'condition_id' => FieldValue::factory()
                    ]),
                ],
            ],
        );

        $response->assertOk();
    }
}

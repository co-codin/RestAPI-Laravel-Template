<?php


namespace Tests\Feature\Modules\Case\Admin;

use Modules\Case\Models\CaseModel;
use Modules\Product\Models\Product;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_case()
    {
        $this->authenticateUser();

        $case = CaseModel::factory()->create();

        $response = $this->json('PATCH', route('admin.cases.update', $case), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('cases', [
            'name' => $newName,
        ]);
    }

    public function test_authenticated_can_update_case_with_products()
    {
        $this->authenticateUser();

        $case = CaseModel::factory()->create();

        $product = Product::factory()->create();

        $response = $this->json('PATCH', route('admin.cases.update', $case), [
            'products' => [
                [
                    'id' => $product->id
                ]
            ]
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('case_model_product', [
            'product_id' => $product->id,
            'case_model_id' => $case->id
        ]);
    }

    public function test_case_slug_should_be_unique()
    {
        $this->authenticateUser();

        CaseModel::factory()->create([
            'slug' => 'slug'
        ]);

        $anotherCase = CaseModel::factory()->create();

        $response = $this->json('PATCH', route('admin.cases.update', $anotherCase), [
            'slug' => 'slug',
        ]);

        $response->assertStatus(422);
    }
}

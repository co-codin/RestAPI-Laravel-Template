<?php


namespace Tests\Feature\Modules\Case\Admin;

use Modules\Case\Models\CaseModel;
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

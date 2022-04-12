<?php


namespace Tests\Feature\Modules\Case\Admin;

use Modules\Case\Models\CaseModel;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_case()
    {
        $this->authenticateUser();

        $caseData = CaseModel::factory()->raw();

        $response = $this->json('POST', route('admin.cases.store'), $caseData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'slug',
                'short_description',
                'full_description',
                'image',
                'is_enabled',
                'created_at',
                'updated_at',
            ]
        ]);
        $this->assertDatabaseHas('cases', [
            'name' => $caseData['name'],
        ]);
    }
}

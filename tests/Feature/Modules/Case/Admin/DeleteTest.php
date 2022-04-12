<?php


namespace Tests\Feature\Modules\Case\Admin;

use Modules\Case\Models\CaseModel;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_case()
    {
        $this->authenticateUser();

        $case = CaseModel::factory()->create();

        $response = $this->deleteJson(route('admin.cases.destroy', $case));

        $response->assertNoContent();

        $this->assertDeleted($case);
    }
}

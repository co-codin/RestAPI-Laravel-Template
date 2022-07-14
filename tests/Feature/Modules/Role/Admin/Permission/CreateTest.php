<?php


namespace Tests\Feature\Modules\Role\Admin\Permission;


use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_permission()
    {
        $this->authenticateAdmin();

        $permissionData = Redirect::factory()->raw();

        $response = $this->json('POST', route('admin.redirects.store'), $redirectData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'destination',
                'source',
                'code',
            ]
        ]);
        $this->assertDatabaseHas('redirects', [
            'destination' => $redirectData['destination'],
            'source' => $redirectData['source'],
        ]);
    }
}

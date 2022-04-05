<?php


namespace Tests\Feature\Modules\Export\Admin;


use Modules\Export\Models\Export;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_export()
    {
        $export = Export::factory()->create();

        $response = $this->json('PATCH', route('admin.exports.update', $export), [
            'name' => 'new name',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_can_update_export()
    {
        $this->authenticateUser();

        $export = Export::factory()->create();

        $response = $this->json('PATCH', route('admin.exports.update', $export), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('exports', [
            'name' => $newName,
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Modules\Publication\Models\Publication;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_publication()
//    {
//        //
//    }

    public function test_authenticated_can_update_publication()
    {
        $publication = Publication::factory()->create([
            'is_enabled' => true,
        ]);

        $response = $this->json('PATCH', route('admin.publications.update', $publication), [
            'name' => $newName = 'new name',
            'is_enabled' => false
        ]);

        $response->assertOk(200);
        $this->assertDatabaseHas('publications', [
            'name' => $newName,
            'is_enabled' => false
        ]);
    }
}

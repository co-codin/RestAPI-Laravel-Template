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
            'is_enabled' => false,
            'image' => null,
            'is_logo_changed' => true,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('publications', [
            'name' => $newName,
            'is_enabled' => false,
        ]);
        $this->assertEmpty(Publication::query()->first()->image);
    }
}

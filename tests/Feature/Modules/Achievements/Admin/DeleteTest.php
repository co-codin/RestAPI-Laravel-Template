<?php


namespace Tests\Feature\Modules\Achievements\Admin;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_achievement()
    {
        //
    }

    public function test_authenticated_can_delete_achievement()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->json('DELETE', route('admin.achievements.destroy', ['achievement' => $achievement->id]));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('achievements', [
            'name' => $achievement->name,
            'image' => $achievement->image,
            'is_enabled' => $achievement->is_enabled,
        ]);
    }
}

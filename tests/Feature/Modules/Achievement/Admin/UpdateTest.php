<?php


namespace Tests\Feature\Modules\Achievement\Admin;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_achievement()
    {
        //
    }

    public function test_authenticated_can_update_achievement()
    {
        $achievement = Achievement::factory()->create([
            'is_enabled' => true,
        ]);

        $response = $this->json('PATCH', route('admin.achievements.update', $achievement), [
            'name' => $newName = 'new name',
            'is_enabled' => false
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('achievements', [
            'name' => $newName,
            'is_enabled' => false
        ]);
    }
}

<?php


namespace Tests\Feature\Modules\Achievement\Admin;

use Modules\Achievement\Enums\AchievementPermission;
use Modules\Achievement\Models\Achievement;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $createPermission = Permission::factory()->create([
            'name' => AchievementPermission::EDIT_ACHIEVEMENTS
        ]);

        $user->givePermissionTo($createPermission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
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

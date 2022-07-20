<?php


namespace Tests\Feature\Modules\Achievement\Admin;

use Illuminate\Support\Facades\Storage;
use Modules\Achievement\Enums\AchievementPermission;
use Modules\Achievement\Models\Achievement;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $createPermission = Permission::factory()->create([
            'name' => AchievementPermission::DELETE_ACHIEVEMENTS
        ]);

        $user->givePermissionTo($createPermission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_achievement()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->deleteJson(route('admin.achievements.destroy', $achievement));

        $response->assertNoContent();

        $this->assertModelMissing($achievement);
    }
}

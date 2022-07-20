<?php


namespace Tests\Feature\Modules\Achievement\Admin;

use Illuminate\Support\Facades\Storage;
use Modules\Achievement\Enums\AchievementPermission;
use Modules\Achievement\Models\Achievement;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $createPermission = Permission::factory()->create([
            'name' => AchievementPermission::CREATE_ACHIEVEMENTS
        ]);

        $user->givePermissionTo($createPermission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_achievement()
    {
        $achievementData = Achievement::factory()->raw();

        $response = $this->json('POST', route('admin.achievements.store'), $achievementData);


        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'image',
                'is_enabled',
            ],
        ]);

        $this->assertDatabaseHas('achievements', [
            'name' => $achievementData['name'],
            'is_enabled' => $achievementData['is_enabled'],
        ]);

        $this->assertTrue(Storage::disk('public')->has($response['data']['image']));
    }
}

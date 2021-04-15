<?php


namespace Tests\Feature\Modules\Achievement\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_achievement()
    {
        //
    }

    public function test_authenticated_can_create_achievement()
    {
        Storage::fake();

        $achievementData = Achievement::factory()->raw([
            'image' => UploadedFile::fake()->create('test.png')
        ]);

        $response = $this->json('POST', route('admin.achievements.store'), $achievementData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'image',
                'is_enabled',
            ]
        ]);
        $this->assertDatabaseHas('achievements', [
            'name' => $achievementData['name'],
            'image' => $achievementData['image'],
            'is_enabled' => $achievementData['is_enabled']
        ]);
    }
}

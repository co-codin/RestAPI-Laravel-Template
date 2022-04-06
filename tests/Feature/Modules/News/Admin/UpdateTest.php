<?php


namespace Tests\Feature\Modules\News\Admin;


use App\Enums\Status;
use Modules\News\Models\News;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_news()
    {
        $news = News::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.news.update', $news), [
            'name' => 'new name',
            'status' => Status::INACTIVE
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_can_update_news()
    {
        $this->authenticateUser();

        $news = News::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.news.update', $news), [
            'name' => $newName = 'new name',
            'status' => Status::INACTIVE
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('news', [
            'name' => $newName,
            'status' => Status::INACTIVE
        ]);
    }
}

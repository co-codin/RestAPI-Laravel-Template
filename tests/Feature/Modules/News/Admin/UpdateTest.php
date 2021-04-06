<?php


namespace Tests\Feature\Modules\News\Admin;


use App\Enums\Status;
use Modules\News\Models\News;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_news()
    {
        //
    }

    public function test_authenticated_can_update_news()
    {
        $this->withoutExceptionHandling();

        $news = News::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.news.update', ['news' => $news->id]), [
            'name' => $newName = 'new name',
            'status' => Status::INACTIVE
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('news', [
            'name' => $newName,
            'status' => Status::INACTIVE
        ]);
    }
}

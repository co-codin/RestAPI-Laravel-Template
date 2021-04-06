<?php


namespace Tests\Feature\Modules\News\Admin;


use Carbon\Carbon;
use Modules\News\Models\News;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_news()
    {
        //
    }

    public function test_authenticated_can_delete_news()
    {
        $news = News::factory()->create();

        $response = $this->json('DELETE', route('admin.news.destroy', ['news' => $news->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted('news', [
            'name' => $news->name,
            'slug' => $news->slug,
        ]);
    }
}

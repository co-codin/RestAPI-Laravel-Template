<?php


namespace Tests\Feature\Modules\News\Admin;


use Carbon\Carbon;
use Modules\News\Models\News;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_news()
    {
        $this->authenticateUser();

        $news = News::factory()->create();

        $response = $this->deleteJson(route('admin.news.destroy', $news));

        $response->assertNoContent();

        $this->assertSoftDeleted($news);
    }
}

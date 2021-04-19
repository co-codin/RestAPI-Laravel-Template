<?php


namespace Tests\Feature\Modules\Property\Admin;


use Carbon\Carbon;
use Modules\News\Models\News;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_property()
    {
        //
    }

    public function test_authenticated_can_delete_property()
    {
        $news = News::factory()->create();

        $response = $this->deleteJson(route('admin.news.destroy', $news));

        $response->assertNoContent();

        $this->assertSoftDeleted($news);
    }
}

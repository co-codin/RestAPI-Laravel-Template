<?php


namespace Tests\Feature\Modules\News\Admin;


use Modules\News\Models\News;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_news()
    {

    }

    public function test_authenticated_user_can_view_news()
    {
        News::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.news.index'));

        $response->assertStatus(200);
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "slug",
                    "short_description",
                    "full_description",
                    "status",
                    "image",
                    "is_in_home",
                    "published_at",
                    "created_at",
                    "updated_at",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_authenticated_user_can_view_single_news()
    {
        $news = News::factory()->create();

        $response = $this->json('GET', route('admin.news.show', ['news' => $news->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "slug",
                "short_description",
                "full_description",
                "status",
                "image",
                "is_in_home",
                "published_at",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}

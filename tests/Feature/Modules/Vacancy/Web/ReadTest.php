<?php


namespace Tests\Feature\Modules\News\Web;


use Modules\News\Models\News;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_news()
    {
        News::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('news.index'));

        $response->assertOk();
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

    public function test_user_can_view_single_news()
    {
        $news = News::factory()->create();

        $response = $this->json('GET', route('news.show', $news));

        $response->assertOk();
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

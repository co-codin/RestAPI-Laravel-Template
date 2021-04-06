<?php


namespace Tests\Feature\Modules\News\Web;


use App\Enums\Status;
use Modules\News\Models\News;
use Tests\TestCase;

class NewsReadTest extends TestCase
{
    public function test_active_news_can_be_viewed()
    {
        $news = News::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->graphQL('
            {
                news {
                    data {
                        id
                        name
                    }
                    paginatorInfo {
                        currentPage
                        lastPage
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'news' => [
                    'data' => [
                        [
                            'id' => $news->id,
                            'name' => $news->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                news(where: { column: ID, operator: EQ, value: ' . $news->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'news' => [
                    'data' => [
                        [
                            'id' => $news->id,
                            'name' => $news->name,
                        ]
                    ],
                ]
            ],
        ]);

    }

    public function test_inactive_news_cannot_be_viewed()
    {
        $news = News::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $secondNews = News::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $thirdNews = News::factory()->create([
            'status' => Status::ONLY_URL,
        ]);

        $response = $this->graphQL('
            {
                news {
                    data {
                        id
                        name
                    }
                    paginatorInfo {
                        currentPage
                        lastPage
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'news' => [
                    'data' => [
                        [
                            'id' => $secondNews->id,
                            'name' => $secondNews->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $this->assertNotContains($news->id, $response->json());
        $this->assertNotContains($thirdNews->id, $response->json());


        $response = $this->graphQL('
            {
                news(where: { column: ID, operator: EQ, value: ' . $secondNews->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'news' => [
                    'data' => [
                        [
                            'id' => $secondNews->id,
                            'name' => $secondNews->name,
                        ]
                    ],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                news(where: { column: ID, operator: EQ, value: ' . $news->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'news' => [
                    'data' => [],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                news(where: { column: ID, operator: EQ, value: ' . $thirdNews->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'news' => [
                    'data' => [],
                ]
            ],
        ]);
    }
}

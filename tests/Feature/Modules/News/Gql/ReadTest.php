<?php


namespace Tests\Feature\Modules\News\Gql;


use App\Enums\Status;
use Modules\News\Models\News;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_news_can_be_viewed()
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
}

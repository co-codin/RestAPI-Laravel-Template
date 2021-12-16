<?php


namespace Tests\Feature\Modules\Faq\Gql;


use App\Enums\Status;
use Modules\Faq\Models\Question;
use Tests\TestCase;

class QuestionReadTest extends TestCase
{
    public function test_questions_can_be_viewed()
    {
        $question = Question::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $response = $this->graphQL('
            {
                questions {
                    data {
                        id
                        question
                        slug
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
                'questions' => [
                    'data' => [
                        [
                            'id' => $question->id,
                            'question' => $question->productQuestion,
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
                questions(where: { column: ID, operator: EQ, value: ' . $question->id .'  }) {
                    data {
                        id
                        question
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'questions' => [
                    'data' => [
                        [
                            'id' => $question->id,
                            'question' => $question->productQuestion,
                        ]
                    ],
                ]
            ],
        ]);

    }
}

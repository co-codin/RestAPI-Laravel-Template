<?php


namespace Tests\Feature\Modules\Faq\Web;


use App\Enums\Status;
use Modules\Faq\Models\Question;
use Tests\TestCase;

class QuestionReadTest extends TestCase
{
    public function test_active_questions_can_be_viewed()
    {
        $question = Question::factory()->create([
            'status' => Status::ACTIVE,
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
                            'question' => $question->question,
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
                            'question' => $question->question,
                        ]
                    ],
                ]
            ],
        ]);

    }

    public function test_inactive_questions_cannot_be_viewed()
    {
        $question = Question::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $anotherQuestion = Question::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $response = $this->graphQL('
            {
                questions {
                    data {
                        id
                        question
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
                            'question' => $question->question,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $this->assertNotContains($anotherQuestion->id, $response->json());

        $response = $this->graphQL('
            {
                questions(where: { column: ID, operator: EQ, value: ' . $question->id . ' }) {
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
                            'question' => $question->question,
                        ]
                    ],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                questions(where: { column: ID, operator: EQ, value: ' . $anotherQuestion->id . ' }) {
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
                    'data' => [],
                ]
            ],
        ]);
    }
}

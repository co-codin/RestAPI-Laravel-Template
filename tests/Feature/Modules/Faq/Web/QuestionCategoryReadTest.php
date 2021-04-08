<?php


namespace Tests\Feature\Modules\Faq\Web;


use App\Enums\Status;
use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class QuestionCategoryReadTest extends TestCase
{
    public function test_active_question_categories_can_be_viewed()
    {
        $questionCategory = QuestionCategory::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->graphQL('
            {
                questionCategories {
                    data {
                        id
                        name
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
                'questionCategories' => [
                    'data' => [
                        [
                            'id' => $questionCategory->id,
                            'name' => $questionCategory->name,
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
                questionCategories(where: { column: ID, operator: EQ, value: ' . $questionCategory->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'questionCategories' => [
                    'data' => [
                        [
                            'id' => $questionCategory->id,
                            'name' => $questionCategory->name,
                        ]
                    ],
                ]
            ],
        ]);

    }

    public function test_inactive_question_categories_cannot_be_viewed()
    {
        $questionCategory = QuestionCategory::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $anotherQuestionCategory = QuestionCategory::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $response = $this->graphQL('
            {
                questionCategories {
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
                'questionCategories' => [
                    'data' => [
                        [
                            'id' => $questionCategory->id,
                            'name' => $questionCategory->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $this->assertNotContains($anotherQuestionCategory->id, $response->json());

        $response = $this->graphQL('
            {
                questionCategories(where: { column: ID, operator: EQ, value: ' . $questionCategory->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'questionCategories' => [
                    'data' => [
                        [
                            'id' => $questionCategory->id,
                            'name' => $questionCategory->name,
                        ]
                    ],
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                questionCategories(where: { column: ID, operator: EQ, value: ' . $anotherQuestionCategory->id . ' }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'questionCategories' => [
                    'data' => [],
                ]
            ],
        ]);
    }
}

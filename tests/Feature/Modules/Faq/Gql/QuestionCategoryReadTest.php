<?php


namespace Tests\Feature\Modules\Faq\Gql;


use App\Enums\Status;
use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class QuestionCategoryReadTest extends TestCase
{
    public function test_question_categories_can_be_viewed()
    {
        $questionCategory = QuestionCategory::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $response = $this->graphQL('
            {
                questionCategories {
                    id
                    name
                    slug
                }
            }
        ');


        $response->assertJson([
            'data' => [
                'questionCategories' => [
                    [
                        'id' => $questionCategory->id,
                        'name' => $questionCategory->name,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                questionCategories(where: { column: ID, operator: EQ, value: ' . $questionCategory->id .'  }) {
                    id
                    name
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'questionCategories' => [
                    [
                        'id' => $questionCategory->id,
                        'name' => $questionCategory->name,
                    ]
                ]
            ],
        ]);

    }
}

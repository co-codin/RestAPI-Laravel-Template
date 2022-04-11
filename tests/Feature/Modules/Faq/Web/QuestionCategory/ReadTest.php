<?php


namespace Tests\Feature\Modules\Faq\Web\QuestionCategory;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_question_categories()
    {
        QuestionCategory::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('question-categories.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "slug",
                    "status",
                    "position",
                    "created_at",
                    "updated_at",
                    "deleted_at",
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

    public function test_user_can_view_single_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create();

        $response = $this->json('GET', route('question-categories.show', $questionCategory));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "slug",
                "status",
                "position",
                "created_at",
                "updated_at",
                "deleted_at",
            ]
        ]);
    }
}

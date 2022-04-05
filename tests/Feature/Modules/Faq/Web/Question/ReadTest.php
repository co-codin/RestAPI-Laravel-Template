<?php


namespace Tests\Feature\Modules\Faq\Web\Question;


use Modules\Faq\Models\Question;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_questions()
    {
        Question::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('questions.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "question",
                    "slug",
                    "answer",
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

    public function test_user_can_view_a_single_question()
    {
        $question = Question::factory()->create();

        $response = $this->json('GET', route('questions.show', $question));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "question",
                "slug",
                "answer",
                "status",
                "position",
                "created_at",
                "updated_at",
                "deleted_at",
            ]
        ]);
    }
}

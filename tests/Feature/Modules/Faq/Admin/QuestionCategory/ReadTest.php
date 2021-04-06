<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_question_category()
    {

    }

    public function test_authenticated_user_can_view_question_categories()
    {
        QuestionCategory::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.question_categories.index'));

        $response->assertStatus(200);
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

    public function test_authenticated_user_can_view_single_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create();

        $response = $this->json('GET', route('admin.question_categories.show', ['question_category' => $questionCategory->id]));

        $response->assertStatus(200);
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
